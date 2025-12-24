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
            'category' => 'required',
            'unit' => 'required',
            'moq' => 'required|numeric',
            'main_image' => 'required|image',
            'details.price.*' => 'nullable|numeric',
        ]);

        $path = $request->file('main_image')->store('products', 'public');

        $product = Product::create([
            'name' => $request->name,
            'slug' => \Str::slug($request->name),
            'category' => $request->category,
            'unit' => $request->unit,
            'moq' => $request->moq,
            'material' => $request->material,
            'description' => $request->description,
            'main_image' => $path,
        ]);

        if ($request->filled('details.price')) {
            foreach ($request->details['price'] as $index => $price) {
                ProductVariation::create([
                    'product_id' => $product->id,
                    'price' => $price ?? 0,
                    'size' => $request->details['size'][$index] ?? null,
                    'color' => $request->details['color'][$index] ?? null,
                    'weight' => $request->details['weight'][$index] ?? null,
                    'finish' => $request->details['finish'][$index] ?? null,
                    'description' => $request->details['notes'][$index] ?? null,
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
