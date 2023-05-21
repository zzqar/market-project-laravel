<?php

namespace App\Http\Controllers;


use App\Forms\ProductForm;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductFavorit;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;


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

    /**
     * @param FormBuilder $formBuilder
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(FormBuilder $formBuilder, Request $request): RedirectResponse
    {
        $form = $formBuilder->create(\App\Forms\ProductForm::class);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $path = $request->file('image')->store('uploads', 'public');

        $product = Product::create([
            'title' => $request->title,
            'description' => $request->description,
            'cost' => $request->cost,
            'category_id' => $request->category_id,
            'image' => '/storage/' . $path,
        ]);
// Установка сообщения об успешном сохранении во флэш-сессию
        $request->session()->flash('success', "Товар '{$product->title}' успешно сохранен.");

        return redirect()->route('createProduct');
    }
}
