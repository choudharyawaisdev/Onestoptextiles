<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view("index.index");
    }

    public function OrderDetails(Request $request)
    {
        return view('checkout.index');
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
