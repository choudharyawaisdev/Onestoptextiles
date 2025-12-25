<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariation;
class CartController extends Controller
{
    public function OrderDetails($id)
    {
        $product = Product::with('variations', 'addons')->findOrFail($id);
        $addonTotal = $product->addons->sum('price');
        return view('checkout.index', compact('product', 'addonTotal'));
    }


     public function success(Request $request)
    {
        return view('checkout.success');
    }

public function addToCart(Request $request)
{
    $product = Product::findOrFail($request->product_id);

    // 1. Get the weight/price from the specific Variation
    $variation = $product->variations()
        ->where('size', $request->size)
        ->where('color', $request->selected_color)
        ->first();

    $unitWeight = $variation ? (float)$variation->weight : (float)$product->weight;
    $unitPrice  = $variation ? (float)$variation->price : (float)$product->price;

    // 2. Handle Multi-select Addons
    $selectedAddons = [];
    $addonsTotalPrice = 0;
    
    if ($request->has('addon_ids')) {
        // Fetch addon details from your Addon model
        $addons = \App\Models\Addon::whereIn('id', $request->addon_ids)->get();
        foreach ($addons as $addon) {
            $selectedAddons[] = [
                'title' => $addon->title,
                'price' => (float)$addon->price
            ];
            $addonsTotalPrice += (float)$addon->price;
        }
    }

    $cart = session()->get('cart', []);

    // 3. Save to Session
    $cart[] = [
        'product_id' => $product->id,
        'name'       => $product->name,
        'image'      => ($variation && $variation->image) ? $variation->image : $product->main_image,
        'color'      => $request->selected_color,
        'size'       => $request->size,
        'material'   => $product->material,
        'weight'     => $unitWeight,
        'quantity'   => (int)$request->quantity,
        'unit_price' => $unitPrice,
        'addons'     => $selectedAddons,
        'addons_total' => $addonsTotalPrice,
        'total_item_price' => ($unitPrice + $addonsTotalPrice) * (int)$request->quantity
    ];

    session()->put('cart', $cart);
    return redirect()->route('checkout');
}


    public function checkout()
    {
        $cart = session()->get('cart', []);
        return view('checkout.checkout', compact('cart'));
    }

}
