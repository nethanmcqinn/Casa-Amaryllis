<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\OrderStatusUpdated;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function dashboard()
    {
        // Get monthly sales for the last 12 months
        $monthlySales = Order::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('SUM(total_amount) as total')
        )
        ->where('created_at', '>=', Carbon::now()->subMonths(12))
        ->groupBy('month')
        ->orderBy('month')
        ->get()
        ->map(function ($item) {
            return [
                'month' => Carbon::createFromFormat('Y-m', $item->month)->format('M Y'),
                'total' => (float) $item->total
            ];
        });

        // Get product category distribution
        $productStats = Product::join('categories', 'products.category_id', '=', 'categories.id')
            ->select('categories.name', DB::raw('count(*) as count'))
            ->groupBy('categories.name')
            ->get();

        // Get user registration trends for last 6 months
        $userStats = User::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('COUNT(*) as count')
        )
        ->where('created_at', '>=', Carbon::now()->subMonths(6))
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        $stats = [
            'total_orders' => Order::count(),
            'total_revenue' => Order::sum('total_amount'),
            'total_customers' => User::where('role', 'customer')->count(),
            'total_products' => Product::count(),
            'monthly_sales' => $monthlySales,
            'product_stats' => $productStats,
            'user_stats' => $userStats
        ];

        // Get all orders for the management table
        $orders = Order::with('user')->latest()->paginate(10);

        return view('admin.dashboard', compact('stats', 'orders'));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        try {
            $validated = $request->validate([
                'status' => 'required|in:pending,processing,shipped,completed,cancelled'
            ]);

            $oldStatus = $order->status;
            $order->status = $validated['status'];
            $order->save();

            // Send email notification
            try {
                Mail::to($order->user->email)->send(new OrderStatusUpdated($order));
                Log::info('Order status update email sent', [
                    'order_id' => $order->id,
                    'old_status' => $oldStatus,
                    'new_status' => $order->status
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to send status update email', [
                    'order_id' => $order->id,
                    'error' => $e->getMessage()
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Order status updated successfully',
                'newStatus' => $order->status
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to update order status', [
                'error' => $e->getMessage(),
                'order_id' => $order->id ?? null
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update status: ' . $e->getMessage()
            ], 500);
        }
    }

    public function reviews()
    {
        $reviews = \App\Models\ProductReview::with(['user', 'product'])
            ->latest()
            ->paginate(10);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function deleteReview(\App\Models\ProductReview $review)
    {
        try {
            $review->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}