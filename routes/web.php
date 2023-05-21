<?php

use App\Http\Controllers\FavoriteProductController;
use App\Http\Controllers\ProductsViewController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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


Route::get('/home', [ProductsViewController::class, 'index'])->middleware('auth')->name('home');
Route::get('/favorite', [FavoriteProductController::class, 'index'])->middleware('auth')->name('favorite');
Route::get('/search', [SearchController::class, 'index'])->middleware('auth')->name('search');

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

