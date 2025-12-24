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

        $product = Product::create([
    'name' => $request->name,
    'price' => $request->price,
    'slug' => \Str::slug($request->name),
    'category' => $request->category,
    'unit' => $request->unit,
    'moq' => $request->moq,
    'material' => $request->material,
    'description' => $request->description,
    'main_image' => $path,
]);

if ($request->filled('addon_ids')) {
    $product->addons()->sync($request->addon_ids); // attach selected addons
}


       if ($request->filled('details.price')) {
        foreach ($request->details['price'] as $index => $price) {

            $variantImagePath = null;

            if ($request->hasFile("details.image.$index")) {
                $variantImagePath = $request->file("details.image.$index")
                ->store('product_variants', 'public');
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
        $product->load('variations');
        return view('admin.product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // 1. Existing Validation (Updated to include variant images)
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required',
            'unit' => 'required',
            'moq' => 'required|numeric',
            'main_image' => 'nullable|image',
            'variant_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // New validation
            'details.price.*' => 'nullable|numeric',
        ]);

        // 2. Handle Main Product Image (Your existing logic)
        $imagePath = $product->main_image; 
        if ($request->hasFile('main_image')) {
            if($product->main_image && \Storage::disk('public')->exists($product->main_image[0] ?? '')){
                \Storage::disk('public')->delete($product->main_image);
            }
            $path = $request->file('main_image')->store('products', 'public');
            $imagePath = [$path];
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

        // 3. Handle Variations and their Images
        $product->variations()->delete(); 

        if ($request->filled('details.price')) {
            foreach ($request->details['price'] as $index => $price) {
                
                $varImage = $request->existing_variant_images[$index] ?? null;

                // Check if a new file was uploaded for this specific variation row
                if ($request->hasFile("variant_images.$index")) {
                    // Delete old one if it exists
                    if ($varImage) {
                        \Storage::disk('public')->delete($varImage);
                    }
                    $varImage = $request->file("variant_images.$index")->store('variants', 'public');
                }

                ProductVariation::create([
                    'product_id' => $product->id,
                    'price' => $price ?? 0,
                    'size'   => $request->details['size'][$index] ?? null,
                    'color'  => $request->details['color'][$index] ?? null,
                    'weight' => $request->details['weight'][$index] ?? null,
                    'finish' => $request->details['finish'][$index] ?? null,
                    'notes'  => $request->details['notes'][$index] ?? null,
                    'image'  => $varImage, // Save the path to the database
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
