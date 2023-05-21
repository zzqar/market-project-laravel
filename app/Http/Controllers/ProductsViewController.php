<?php

namespace App\Http\Controllers;


use App\Forms\ProductForm;
use App\Forms\ReviewForm;
use App\Models\Category;
use App\Models\File;
use App\Models\Product;
use App\Models\ProductFavorit;
use App\Models\Review;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function detail(FormBuilder $formBuilder, Request $request)
    {
        $id = $request->get('id');
        $product = \App\Models\Product::find($id);
        if (empty($product)) {
            return redirect()->back();
        }

        $form = $formBuilder->create(ReviewForm::class, [
            'method' => 'POST',
            'url' => route('review'),
            'enctype' => 'multipart/form-data'
        ]);

        $form->add('product_id', 'hidden', [
            'default_value' => $product->id,
        ]);

        $reviews = Review::where('product_id', $product->id)->get();

        $images = [];
        foreach ($reviews as $review) {
            $images[$review->id] = File::where('object', '=', $review->getTable())
                ->where('object_id', '=', $review->id)
                ->get();
        }

        $usersName = (new \Illuminate\Foundation\Auth\User)->pluck('name', 'id')->toArray();

        return view('product', [
            'product' => $product,
            'form' => $form,
            'reviews' => $reviews,
            'images' => $images,
            'names' => $usersName,
        ]);
    }

}
