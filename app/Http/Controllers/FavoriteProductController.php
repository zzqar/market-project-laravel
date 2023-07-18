<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductFavorit;
use Illuminate\Http\Request;

class FavoriteProductController extends Controller
{
    public function index()
    {
        $userID = auth()->user()->id;
        $favorite = ProductFavorit::where('user_id', '=', $userID)->get()->toArray();
        $productIDs = array_column($favorite, 'product_id');
        $products = Product::whereIn('id', $productIDs)->get();

        return view('favorite', compact('products'));
    }
}
