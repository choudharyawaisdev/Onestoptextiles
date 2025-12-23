<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariation;
class CartController extends Controller
{
    public function OrderDetails($id)
    {
        $product = Product::with('variations')->findOrFail($id);
        // dd($product);
        return view('checkout.index', compact('product'));
    }

     public function checkout(Request $request)
    {
        return view('checkout.checkout');
    }

     public function success(Request $request)
    {
        return view('checkout.success');
    }
}
