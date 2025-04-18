<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $query = Product::with('category');
        
        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        // Add price filtering
        if ($request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }
        
        $products = $query->latest()->paginate(12);
        
        // Get min and max prices for the filter
        $priceRange = Product::selectRaw('MIN(price) as min_price, MAX(price) as max_price')->first();
        
        return view('shop.index', compact('products', 'categories', 'priceRange'));
    }

    public function addtocart(Request $request)
    {
        return view(view: 'cart.index', data:$request);
    }

    public function show(Product $product)
    {
        return view('shop.show', compact('product'));
    }
}

