<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\AddOn;
use App\Models\ProductVariation;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product = Product::all();
        return view('product.index', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $addons = AddOn::all();
        return view('admin.product.create', compact('addons'));
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'category' => 'required',
        'unit' => 'required',
        'moq' => 'required|numeric',
        'main_image' => 'required|image',
        'details.price.*' => 'nullable|numeric',
        'details.image.*' => 'nullable|image|max:2048',
    ]);

    $path = $request->file('main_image')->store('products', 'public');

    $name = $request->name;
    $slug = \Str::slug($name);
    $originalSlug = $slug;
    $counter = 1;

    while (Product::where('slug', $slug)->exists()) {
        $slug = $originalSlug . '-' . $counter;
        $counter++;
    }

    $product = Product::create([
        'name' => $request->name,
        'price' => $request->price,
        'slug' => $slug,
        'category' => $request->category,
        'unit' => $request->unit,
        'moq' => $request->moq,
        'material' => $request->material,
        'description' => $request->description,
        'main_image' => $path,
    ]);

    if ($request->filled('addon_ids')) {
        $product->addons()->sync($request->addon_ids);
    }

    if ($request->filled('details.price')) {
        foreach ($request->details['price'] as $index => $price) {
            $variantImagePath = null;
            if ($request->hasFile("details.image.$index")) {
                $variantImagePath = $request->file("details.image.$index")->store('product_variants', 'public');
            }

            ProductVariation::create([
                'product_id' => $product->id,
                'price' => $price ?? 0,
                'size' => $request->details['size'][$index] ?? null,
                'color' => $request->details['color'][$index] ?? null,
                'weight' => $request->details['weight'][$index] ?? null,
                'finish' => $request->details['finish'][$index] ?? null,
                'description' => $request->details['notes'][$index] ?? null,
                'image' => $variantImagePath,
            ]);
        }
    }

    return redirect()->back()->with('success', 'Saved!');
}



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
 public function edit(Product $product)
{
    $product->load(['variations', 'addons']);
    $addons = AddOn::all();
    return view('admin.product.edit', compact('product', 'addons'));
}

public function update(Request $request, Product $product)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'category' => 'required',
        'unit' => 'required',
        'moq' => 'required|numeric',
        'main_image' => 'nullable|image',
        'details.price.*' => 'nullable|numeric',
        'details.image.*' => 'nullable|image|max:2048',
    ]);

    $imagePath = $product->main_image; 
    if ($request->hasFile('main_image')) {
        if($product->main_image && \Storage::disk('public')->exists($product->main_image)){
            \Storage::disk('public')->delete($product->main_image);
        }
        $imagePath = $request->file('main_image')->store('products', 'public');
    }

    $product->update([
        'name' => $request->name,
        'slug' => \Str::slug($request->name),
        'category' => $request->category,
        'unit' => $request->unit,
        'moq' => $request->moq,
        'material' => $request->material,
        'description' => $request->description,
        'main_image' => $imagePath,
    ]);

    if ($request->has('addon_ids')) {
        $product->addons()->sync($request->addon_ids);
    } else {
        $product->addons()->detach();
    }

    $product->variations()->delete(); 

    if ($request->filled('details.price')) {
        foreach ($request->details['price'] as $index => $price) {
            
            $variantImagePath = $request->existing_variant_images[$index] ?? null;

            if ($request->hasFile("details.image.$index")) {
                if ($variantImagePath && \Storage::disk('public')->exists($variantImagePath)) {
                    \Storage::disk('public')->delete($variantImagePath);
                }
                $variantImagePath = $request->file("details.image.$index")->store('product_variants', 'public');
            }

            ProductVariation::create([
                'product_id' => $product->id,
                'price' => $price ?? 0,
                'size' => $request->details['size'][$index] ?? null,
                'color' => $request->details['color'][$index] ?? null,
                'weight' => $request->details['weight'][$index] ?? null,
                'finish' => $request->details['finish'][$index] ?? null,
                'description' => $request->details['notes'][$index] ?? null,
                'image' => $variantImagePath,
            ]);
        }
    }

    return redirect()->route('product.index')->with('success', 'Product updated successfully!');
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
