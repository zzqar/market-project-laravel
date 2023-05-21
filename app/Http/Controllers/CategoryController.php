<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
}
