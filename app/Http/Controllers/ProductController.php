<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ProductController extends Controller
{


    public function show(Product $product)
    {
        $product->load(['reviews.user' => function($query) {
            $query->orderBy('created_at', 'desc');
        }]);
        return view('shop.show', compact('product'));
    }

    public function storeReview(Request $request, Product $product)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000'
        ]);

        $review = $product->reviews()->create([
            'user_id' => auth()->id(),
            'rating' => $validated['rating'],
            'comment' => $validated['comment']
        ]);

        return back()->with('success', 'Review added successfully!');
    }

    public function updateReview(Request $request, ProductReview $review)
    {
        $this->authorize('update', $review);
        
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000'
        ]);

        $review->update($validated);
        return response()->json(['success' => true]);
    }

    public function deleteReview(Review $review)
    {
        $this->authorize('delete', $review);
        
       $review->delete();
        return back()->with('success', 'Review deleted successfully!');
    }

}
