<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', auth()->id())
                        ->with('product')
                        ->get();
        return view('cart.index', compact('cartItems'));
    }

    public function addToCart(Request $request)
    {
        try {
            $validated = $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1|max:10'
            ]);

            $product = Product::findOrFail($validated['product_id']);

            $existingItem = Cart::where('user_id', auth()->id())
                               ->where('product_id', $validated['product_id'])
                               ->first();

            if ($existingItem) {
                $newQuantity = $existingItem->quantity + $validated['quantity'];
                if ($newQuantity > 10) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Maximum quantity per product is 10'
                    ], 422);
                }
                $existingItem->increment('quantity', $validated['quantity']);
            } else {
                Cart::create([
                    'user_id' => auth()->id(),
                    'product_id' => $validated['product_id'],
                    'quantity' => $validated['quantity']
                ]);
            }

            $cartCount = Cart::where('user_id', auth()->id())->sum('quantity');

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product added to cart successfully',
                    'cart_count' => $cartCount
                ]);
            }

            return redirect()->route('cart.index')
                ->with('success', 'Product added to cart successfully');


        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to add product to cart: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Failed to add product to cart: ' . $e->getMessage());

        }

    }
}
