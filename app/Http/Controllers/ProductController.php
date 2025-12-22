<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
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
        return view('product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    // 1. Validation
    $request->validate([
        'name' => 'required|string|max:255',
        'category' => 'required|string|in:blanket,curtain,fabric,fitted_sheet',
        'material' => 'nullable|string|max:255',
        'main_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        'details.price.*' => 'required|numeric|min:0',
        'details.images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120'
    ]);

    // 2. Save Main Product
    $mainImagePath = $request->file('main_image')->store('products', 'public');

    $product = Product::create([
        'name' => $request->name,
        'slug' => Str::slug($request->name),
        'category' => $request->category,
        'main_image' => $mainImagePath,
        'material' => $request->material,
    ]);

    // 3. Save Variations
    if ($request->has('details')) {
        $details = $request->input('details');
        
        foreach ($details['price'] as $index => $price) {
            $variantImages = [];

            // Handle Nested File Upload correctly
            if ($request->hasFile("details.images.$index")) {
                $files = $request->file("details.images.$index");
                // In case "multiple" allows more than one image per variant
                if (is_array($files)) {
                    foreach ($files as $file) {
                        $variantImages[] = $file->store('products/variants', 'public');
                    }
                } else {
                    $variantImages[] = $files->store('products/variants', 'public');
                }
            }

            ProductVariation::create([
                'product_id'  => $product->id,
                'size'        => $details['size'][$index] ?? null,
                'color'       => $details['color'][$index] ?? null,
                'price'       => $price,
                'weight'      => $details['weight'][$index] ?? null,
                'description' => $details['description'][$index] ?? null,
                'images'      => $variantImages, // This will be saved as JSON
            ]);
            // dd($details);
        }
    }

    return redirect()->route('product.create')->with('success', 'Product and variants created successfully!');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
