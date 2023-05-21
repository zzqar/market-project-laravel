<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $searchTerm = $request->text ?? '';
// Поиск по заголовкам товаров
        $products = DB::table('products as p')
            ->where('title', 'LIKE', '%' . $searchTerm . '%')
            ->select('p.id', 'title', 'description', DB::raw("COUNT(r.id) as count"))
            ->leftJoin('reviews as r', 'r.product_id', '=', 'p.id')
            ->groupBy('p.id');

// Поиск по наименованию категорий
        $categories = DB::table('categories as c')
            ->where('name', 'LIKE', '%' . $searchTerm . '%')
            ->select('c.id', DB::raw("name as title"),  DB::raw("'' as description"), DB::raw("COUNT(r.id) as count"))
            ->leftJoin('products as p', 'p.category_id', '=', 'c.id')
            ->leftJoin('reviews as r', 'r.product_id', '=', 'p.id')
            ->groupBy('c.id');

        $results = $products->union($categories)

            ->orderBy('count', 'desc')
            ->get()->toArray();

        return view('search', compact('results'));
    }
}
