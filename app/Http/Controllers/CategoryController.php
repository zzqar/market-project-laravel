<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Kris\LaravelFormBuilder\FormBuilder;

class CategoryController extends Controller
{

    /**
     * @param FormBuilder $formBuilder
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(FormBuilder $formBuilder, Request $request)
    {
        $form = $formBuilder->create(\App\Forms\CategoryForm::class);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $category = Category::firstOrCreate([
            'name' => $request->name,
        ]);

        $request->session()->flash('success', "Категория '{$category->name}' успешно сохранен.");

        return redirect()->route('createCategory');
    }

    public function popularCategories()
    {
        $categories = DB::table('categories as c')
            ->select('c.*', DB::raw("'' as description"), DB::raw("COUNT(r.id) as count"))
            ->join('products as p', 'p.category_id', '=', 'c.id')
            ->join('reviews as r', 'r.product_id', '=', 'p.id')
            ->groupBy('c.id')
            ->orderBy('count', 'desc')
            ->get();

        $categories = json_decode(json_encode($categories), true);

        foreach ($categories as &$category) {
            $category['products'] =  $products = DB::table('products as p')
                ->select('p.*', DB::raw("COUNT(r.id) as count"))
                ->where('category_id', '=', $category['id'])
                ->leftJoin('reviews as r', 'r.product_id', '=', 'p.id')
                ->groupBy('p.id')->get();
        }

        return view('popular', [
            'categories' => $categories,
        ]);
    }

}
