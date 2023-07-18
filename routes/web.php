<?php

use App\Forms\CategoryForm;
use App\Forms\ProductForm;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FavoriteProductController;
use App\Http\Controllers\ProductsViewController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Kris\LaravelFormBuilder\FormBuilder;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', static function (){
    return redirect('home');
});

Route::get('/home', [ProductsViewController::class, 'index'])->middleware('auth')->name('home');
Route::get('/favorite', [FavoriteProductController::class, 'index'])->middleware('auth')->name('favorite');
Route::get('/search', [SearchController::class, 'index'])->middleware('auth')->name('search');
Route::get('/product/detail',[ProductsViewController::class, 'detail'])->middleware('auth')->name('productinfo');
Route::get('/category/popular',[CategoryController::class, 'popularCategories'])->middleware('auth')->name('popularCategories');



Route::namespace('form.')->middleware('auth')->group(function () {
    Route::get('/product/create', static function (FormBuilder $formBuilder) {
        $form = $formBuilder->create(ProductForm::class, [
            'method' => 'POST',
            'url' => \route('product'),
        ]);
        $name = "Товар";
        return view('create', compact('form', 'name'));
    })->name('createProduct');

    Route::get('/category/create', static function (FormBuilder $formBuilder) {
        $form = $formBuilder->create(CategoryForm::class, [
            'method' => 'POST',
            'url' => \route('category'),
        ]);
        $name = "Категория";
        return view('create', compact('form', 'name'));
    })->name('createCategory');
});

Route::namespace('create.')->middleware('auth')->group(function () {
    Route::post('/product/store', [ProductsViewController::class, 'store'])->name('product');
    Route::post('/category/store', [CategoryController::class, 'store'])->name('category');
    Route::post('/review/store', [ReviewController::class, 'store'])->name('review');
});


Auth::routes();

Route::get('/clear', static function () {
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return "Кэш очищен.";
});

Route::post('/addToFavorites', [\App\Http\Controllers\AjaxController::class, 'addFavorite']);
Route::post('/deleteToFavorites', [\App\Http\Controllers\AjaxController::class, 'deleteFavorite']);

