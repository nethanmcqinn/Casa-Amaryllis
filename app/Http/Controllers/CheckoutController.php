<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Mail\OrderConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $cartItems = auth()->user()->carts()->with('product')->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty');
        }

        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        return view('checkout.index', compact('cartItems', 'total'));
    }

    public function checkoutProduct($id)
    {
        $product = Product::findOrFail($id);
        $user = auth()->user();
        
        return view('checkout.product', compact('product', 'user'));
    }

    public function processCheckout(Request $request)
    {
        $validated = $request->validate([
            'shipping_address' => 'required|string|max:255',
            'shipping_city' => 'required|string|max:100',
            'shipping_state' => 'required|string|max:100',
            'shipping_zipcode' => 'required|string|max:20',
            'payment_method' => 'required|in:cash_on_delivery,card'
        ]);

        DB::beginTransaction();
        
        try {
            $cartItems = auth()->user()->carts()->with('product')->get();
            
            if ($cartItems->isEmpty()) {
                throw new \Exception('Cart is empty');
            }

            $total = $cartItems->sum(function($item) {
                return $item->quantity * $item->product->price;
            });

            // Create order
            $order = Order::create([
                'user_id' => auth()->id(),
                'total_amount' => $total,
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'shipping_address' => $request->shipping_address,
                'shipping_city' => $request->shipping_city,
                'shipping_state' => $request->shipping_state,
                'shipping_zipcode' => $request->shipping_zipcode,
            ]);

            // Create order items from cart
            foreach($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price
                ]);
            }

            // Clear cart
            auth()->user()->carts()->delete();

            // Send order confirmation email
            Mail::to(auth()->user()->email)->queue(new OrderConfirmation($order));

            DB::commit();

            return redirect()->route('checkout.success', $order)
                ->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Failed to place order: ' . $e->getMessage());
        }
    }

    public function success(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        return view('checkout.success', compact('order'));
    }
}
