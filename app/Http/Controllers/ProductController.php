<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('categories')->paginate(10);
        return view('products.index', compact('products'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);
    
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }
    
        $product = Product::create($validated);
    
        $product->categories()->attach($request->categories);
    
        return redirect()->route('admin.product.index')->with('success', 'Product created successfully!');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|array',
            'category_id.*' => 'exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
    
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::delete('public/' . $product->image);
            }

            $validated['image'] = $request->file('image')->store('products', 'public');
        } else {
            unset($validated['image']);
        }
    
        $product->update($validated);
    
        $product->categories()->sync($request->category_id);
    
        return redirect()->route('admin.product.index')->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->image && Storage::exists('public/' . $product->image)) {
            Storage::delete('public/' . $product->image);
        }
    
        $product->delete();
    
        return redirect()->route('admin.product.index')->with('success', 'Product deleted successfully!');
    }
    
    // dinggo customer
    public function getProducts(Request $request)
    {
        $categories = Category::all();
        
        $selectedCategories = $request->input('category', []);
    
        if (in_array('all', $selectedCategories) || empty($selectedCategories)) {
            $products = Product::paginate(8);
        } else {
            $products = Product::whereHas('categories', function($query) use ($selectedCategories) {
                $query->whereIn('categories.id', $selectedCategories);
            })->paginate(8);
        }
    
        return view('product', compact('products', 'categories', 'selectedCategories'));
    }

    public function detailProducts(Product $product)
    {
        return view('product-detail', compact('product'));
    }
    
}
