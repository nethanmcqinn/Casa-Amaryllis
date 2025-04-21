<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Http\Controllers\Controller;
use App\DataTables\ProductDataTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(ProductDataTable $dataTable)
    {
        return $dataTable->render('admin.products.index');
    }
    

    public function show(){
        return view('admin.products.create');
  
    }
    

    public function create()
    {
        $show='show';
        dd($show);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'images' => 'required|array',
            'images.*' => 'image|max:2048',
            'category_id' => 'nullable|exists:categories,id'
        ]);

        try {
            DB::beginTransaction();

            // Get the first image as the main product image
            $mainImage = $request->file('images')[0];
            $mainImagePath = $mainImage->store('products', 'public');

            $product = \App\Models\Product::create([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'stock' => $validated['stock'],
                'image' => $mainImagePath,
                'category_id' => $validated['category_id']
            ]);

            // Store additional images
            foreach ($request->file('images') as $index => $image) {
                if ($index === 0) continue; // Skip the main image
                $path = $image->store('products', 'public');
                $product->images()->create([
                    'image_path' => $path
                ]);
            }

            DB::commit();
            return redirect()->route('admin.products.index')
                           ->with('success', 'Product created successfully with multiple images');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create product: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function edit(\App\Models\Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, \App\Models\Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'sometimes|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($product->image);
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

        $product->update($validated);
        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully');
    }

    public function destroy($product)
    {
        dd($product);
        Storage::disk('public')->delete($product->image);
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully');
    }

    public function products_delete($product)
    {
        //dd($product);
        $del=Product::find($product);
        if($del->delete($del)){ 
            return redirect()->back()->with("success", "Item Deleted Successfully");
        } else {
            return redirect()->back()->with("error", "Failed to delete item");
        }
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully');
    }

    public function restore($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->restore();

        return redirect()->route('admin.products.index')->with('success', 'Product restored successfully');
    }
    public function import(Request $request)
{
    $request->validate([
        'csv_file' => 'required|mimes:csv,txt'
    ]);

    $path = $request->file('csv_file')->getRealPath();
    $file = fopen($path, 'r');

    $header = fgetcsv($file); // Read the header row
    $successCount = 0;
    $errorCount = 0;

    while (($row = fgetcsv($file)) !== false) {
        try {
            // Map CSV columns based on your products table
            [$name, $description, $price, $stock, $image, $category_id] = $row;

            Product::create([
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'stock' => $stock,
                'image' => $image,
                'category_id' => $category_id,
            ]);

            $successCount++;
        } catch (\Exception $e) {
            $errorCount++;
        }
    }

    fclose($file);

    return redirect()->route('admin.products.index')->with('success', "$successCount products imported, $errorCount failed.");
}

}
