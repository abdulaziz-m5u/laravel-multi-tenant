<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::inRandomOrder()->get();
        $companies = User::whereHas('roles', function ($q) {
            $q->whereTitle('user');
        })->inRandomOrder()->take(8)->get();
        return view('frontend.homepage', compact('products', 'companies'));
    }

    public function search(Request $request)
    {
        $products = Product::with('created_by')
            ->where('name', 'LIKE', "%$request->search%")
            ->orWhere('description', 'LIKE', "%$request->search%")
            ->get();

        return view('frontend.search', compact('products'));
    }
}
