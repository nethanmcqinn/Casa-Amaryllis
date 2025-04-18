<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Redirect;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        // Check if orders table exists
        try {
            $stats = [
                'total_orders' => Order::count() ?? 0,
                'total_revenue' => Order::sum('total_amount') ?? 0,
                'total_products' => Product::count() ?? 0,
                'total_customers' => User::where('role', 'customer')->count() ?? 0,
                'recent_orders' => Order::with('user')
                                    ->latest()
                                    ->take(5)
                                    ->get() ?? [],
                'monthly_sales' => $this->getMonthlyStats() ?? []
            ];
            
            // Create a simple orders chart for the dashboard
            $ordersChart = new LaravelChart([
                'chart_title' => 'Recent Orders',
                'report_type' => 'group_by_date',
                'model' => 'App\\Models\\Order',
                'group_by_field' => 'created_at',
                'group_by_period' => 'day',
                'chart_type' => 'line',
                'filter_field' => 'created_at',
                'filter_days' => 14, // Last 14 days
            ]);
            
        } catch (\Exception $e) {
            $stats = [
                'total_orders' => 0,
                'total_revenue' => 0,
                'total_products' => Product::count() ?? 0,
                'total_customers' => User::where('role', 'customer')->count() ?? 0,
                'recent_orders' => [],
                'monthly_sales' => []
            ];
            $ordersChart = null;
        }

        return view('admin.dashboard', compact('stats', 'ordersChart'));
    }

    private function getMonthlyStats()
    {
        return Order::selectRaw('SUM(total_amount) as total, DATE_FORMAT(created_at, "%Y-%m") as month')
            ->groupBy('month')
            ->orderBy('month', 'DESC')
            ->take(6)
            ->get()
            ->reverse();
    }

  
}
