<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = $request->text;
// Поиск по заголовкам товаров
        $products = DB::table('products')
            ->where('title', 'LIKE', '%' . $searchTerm . '%')
            ->select('id', 'title', 'description');

// Поиск по наименованию категорий
        $categories = DB::table('categories')
            ->where('name', 'LIKE', '%' . $searchTerm . '%')
            ->select('id', DB::raw("'name' as title"),  DB::raw("'' as description"));


        $results = $products->union($categories)
            ->select('id', 'title', 'description')
            ->orderBy('id')
            ->get();

        return view('search', compact('results'));
    }
}
