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
        $product = Product::all();
        return view('product.index', compact('product'));
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
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:blanket,curtain,fabric,fitted_sheet',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'material' => 'nullable|string|max:255',
            'main_image' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',

            'details.price.*' => 'nullable|numeric|min:0',
            'details.size.*' => 'nullable|string|max:100',
            // 'details.width.*' => 'nullable|string|max:50',
            // 'details.length.*' => 'nullable|string|max:50',
            'details.color.*' => 'nullable|string|max:100',
            'details.weight.*' => 'nullable|string|max:50',
            'details.finish.*' => 'nullable|string|max:100',
            'details.description.*' => 'nullable|string',
            'details.images.*.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $mainImagePath = $request->file('main_image')->store('products', 'public');

        $product = Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category' => $request->category,
            'price' => $request->price,
            'description' => $request->description,
            'material' => $request->material,
            'main_image' => $mainImagePath,
        ]);

        if ($request->filled('details.price')) {
            foreach ($request->details['price'] as $index => $variantPrice) {
                if ($variantPrice === null)
                    continue;

                $variantImages = [];
                    if ($request->hasFile("details.images.$index")) {
                        $files = $request->file("details.images.$index");
                        if (!is_array($files)) {
                            $files = [$files]; // make it an array if single file
                        }
                        foreach ($files as $file) {
                            $variantImages[] = $file->store('products/variants', 'public');
                        }
                    }

                ProductVariation::create([
                    'product_id' => $product->id,
                    'price' => $variantPrice,
                    'description' => $request->details['description'][$index] ?? null,
                    'images' => $variantImages,
                    'size' => $request->details['size'][$index] ?? null,
                    // 'width' => $request->details['width'][$index] ?? null,
                    // 'length' => $request->details['length'][$index] ?? null,
                    'color' => $request->details['color'][$index] ?? null,
                    'weight' => $request->details['weight'][$index] ?? null,
                    'finish' => $request->details['finish'][$index] ?? null,
                ]);
            }
        }

        return redirect()->route('product.create')->with('success', 'Product and variants saved successfully!');
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
