<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index($subdomain)
    {
        $shop = User::with('products')
            ->whereSubdomain($subdomain)
            ->firstOrFail();
        
        return view('frontend.products.index', compact('shop'));
    }

    public function show(Request $request, Product $product)
    {
        $product = Product::findOrFail($request->product);
        
        $product->load('created_by');
        // dd($product);

        return view('frontend.products.show', compact('product'));
    }
}
