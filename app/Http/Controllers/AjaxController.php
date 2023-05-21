<?php

namespace App\Http\Controllers;

use App\Models\ProductFavorit;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function addFavorite(Request $request)
    {
        $userId = $request->user()->id;
        $productId = $request->changedID;

        // Проверяем, существует ли уже запись в таблице "Избранное"
        $existingFavorite = ProductFavorit::where('user_id', $userId)->where('product_id', $productId)->first();

        if ($existingFavorite) {
            return response()->json(['success' => false, 'message' => 'Запись уже существует']);
        }

        $favorite = new ProductFavorit();
        $favorite->user_id = $userId;
        $favorite->product_id = $productId;
        $favorite->save();

        // Проверяем, была ли успешно создана новая запись
        return response()->json(['success' => true]);
    }

    public function deleteFavorite(Request $request)
    {
        $userId = $request->user()->id;
        $productId = $request->changedID;

        // Проверяем, существует ли уже запись в таблице "Избранное"
        $existingFavorite = ProductFavorit::where('user_id', $userId)->where('product_id', $productId)->first();

        if ($existingFavorite) {
            $existingFavorite->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
}
