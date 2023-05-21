<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;

class ReviewController extends Controller
{
    public const MAX_IMAGES = 3;

    public function store(FormBuilder $formBuilder, Request $request): RedirectResponse
    {
        $form = $formBuilder->create(\App\Forms\ReviewForm::class);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $uploadedImages = $request->file('images');

        if (count($uploadedImages ?? []) > self::MAX_IMAGES) {
            return redirect()->back()->withErrors('Максимальное количество изображений - 3');
        }


        $review = Review::create([
            'user_id' => auth()->user()->id,
            'product_id' => $request->product_id,
            'content' => $request->get('content'),
        ]);

        if (isset($uploadedImages)) {
            foreach ($uploadedImages as $image) {
                $path = $image->store('uploads', 'public');
                File::create([
                    'object' => $review->getTable(),
                    'object_id' => $review->id,
                    'path' => '/storage/' . $path,
                ]);
            }
        }
        $request->session()->flash('success', "Отзыв успешно сохранен.");
        return redirect()->back();
    }
}
