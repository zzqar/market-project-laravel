<?php

namespace App\Forms;

use App\Models\Category;
use Kris\LaravelFormBuilder\Form;

class ProductForm extends Form
{
    public function buildForm()
    {
        $categories = Category::pluck('name', 'id')->all();

        $this
            ->add('title', 'text', [
                'rules' => 'required'
            ])
            ->add('description', 'textarea')
            ->add('image', 'file', [
                'attr' => ['accept' => 'image/*'],
                'rules' => 'required|image'
            ])
            ->add('cost', 'number', [
                'rules' => 'required'
            ])
            ->add('category_id', 'select', [
                'choices' => $categories,
                'label' => 'Category',
                'rules' => 'required'
            ])
            ->add('submit', 'submit')
        ;
    }
}
