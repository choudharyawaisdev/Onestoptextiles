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

        $cart = session()->get('cart', []);

        $cart[] = [
            'product_id' => $product->id,
            'name'       => $product->name,
            'image'      => $product->main_image,
            'color'      => $request->selected_color,
            'size'       => $request->size,
            'weight'     => $request->weight,
            'quantity'   => $request->quantity,
            'price'      => $request->price,
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
