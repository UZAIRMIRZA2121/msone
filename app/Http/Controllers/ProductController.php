<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\MainCategory;

class ProductController extends Controller
{
    // Display a listing of the products.
    public function index()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    // Show the form for creating a new product.
    public function create()
    {
        $products = Product::all();
        $categories = Category::all();
        return view('admin.products.create', compact('products', 'categories'));
    }

    // Store a newly created product in storage.
    public function store(Request $request)
    {
        if ($request->input('related_product_id')) {
            // Convert related product IDs array to string
            $relatedProductIds = implode(',', $request->input('related_product_id'));
        } else {
            $relatedProductIds = NULL;
        }

        // Handle image upload
        if ($request->hasFile('img')) {
            // Get the file name with extension
            $fileNameWithExt = $request->file('img')->getClientOriginalName();
            // Get just file name
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            // Get just extension
            $extension = $request->file('img')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $fileName . '_' . time() . '.' . $extension;
            // Upload image to server's filesystem
            $path = $request->file('img')->move(public_path('frontend-asset/product_images'), $fileNameToStore);
            $path = 'frontend-asset/product_images/' . $fileNameToStore;
        } else {
            $path = 'noimage.jpg'; // Placeholder image if no image is uploaded
        }
        // Create new product with image path
        $product = Product::create([
            'name' => $request->name,
            'desc' => $request->desc,
            'pres' => $request->pres,
            'img' => $path, // Store image path
            'qty' => $request->qty,
            'price' => $request->price,
            'discount' => $request->discount,
            'formula' => $request->formula,
            'category_id' => $request->category_id,
            'related_product_id' => $relatedProductIds // Assign string of related product IDs
        ]);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }




    // Display the specified product.
    public function show($id)
    {
        $product = Product::find($id);
        return view('products.show', compact('product'));
    }

    // Show the form for editing the specified product.
    public function edit($id)
    {
        $product = Product::find($id);
        $products = Product::all();
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'products', 'categories'));
    }

    // Update the specified product in storage.
    public function update(Request $request, $id)
    {


        $product = Product::find($id);
        $product->name = $request->input('name');
        $product->desc = $request->input('desc');
        $product->pres = $request->input('pres');
        // Update other fields similarly
        $product->qty = $request->input('qty');
        $product->price = $request->input('price');
        $product->discount = $request->input('discount');
        $product->formula = $request->input('formula');
        $product->category_id = $request->input('category_id');
        $inputValue = $request->input('related_product_id');
        $product->related_product_id = is_array($inputValue) ? implode(',', $inputValue) : NULL;
        
        // Update the image if a new one is uploaded
        if ($request->hasFile('img')) {
            // Handle image upload
            $image = $request->file('img');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('frontend-asset/product_images'), $imageName);
            $imagePath = 'frontend-asset/product_images/' . $imageName;
            $product->img = $imagePath;
        }
        // Save the updated product
        $product->save();
        return redirect()->route('products.index');
    }


    // Remove the specified product from storage.
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect()->route('products.index');
    }


    public function getByMainCategory($mainCategoryId)
    {
       dd(2);
    }
}
