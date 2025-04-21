<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Mail\OrderStatusUpdated;
use App\Mail\OrderConfirmation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function status_update(Request $request)
    {
        try {
            $order = Order::with('user')->findOrFail($request->id);
            $oldStatus = $order->status;
            $order->status = $request->status;
            $order->save();

            // Send email notification
            Mail::to($order->user->email)->send(new OrderStatusUpdated($order));
            Log::info('Order status update email sent', [
                'order_id' => $order->id,
                'user_email' => $order->user->email,
                'old_status' => $oldStatus,
                'new_status' => $order->status
            ]);

            return Redirect()->back()->with('success', 'Order status updated successfully');
        } catch (\Exception $e) {
            Log::error('Failed to update order status: ' . $e->getMessage());
            return Redirect()->back()->with('error', 'Failed to update order status');
        }
    }
    public function downloadReceipt($orderId)
{
    $order = Order::with('items.product')->findOrFail($orderId);

    $pdf = Pdf::loadView('pdf.receipt', compact('order'));

    return $pdf->download('receipt_' . $order->id . '.pdf');
}
}
