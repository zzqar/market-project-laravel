<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Models\Product;
use App\Models\ProductFavorit;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;


class  ProductsViewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return Renderable
     */
    public function index(Request $request): string
    {
        $category = Category::all();

        $user = auth()->user()->id;
        $catTab = $request->id ?? 0;
        if ($catTab) {
            $products = Product::where('category_id', '=', $catTab)->get();
        } else {
            $products = Product::all();
        }
        $favorite = ProductFavorit::where('user_id', '=', $user)->get()->toArray();
        $favorite = array_column($favorite, null, 'product_id');

        return view('home', compact(
            'catTab',
            'category',
            'products',
            'favorite'
        ));
    }
}
