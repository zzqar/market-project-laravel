<?php

namespace App\Forms;

use App\Models\Category;
use Kris\LaravelFormBuilder\Form;

class ReviewForm extends Form
{
    public function buildForm()
    {

        $this
            ->add('content', 'textarea', [
                'label' => 'Коментарий:',
                'attr' => ['rows' => 3],
                'rules' => 'required',
                'wrapper' => ['class' => 'mb-3'] // Add a CSS class to the wrapper div
            ])
            ->add('images', 'file', [
                'label' => 'Изображения:',
                'attr' => ['accept' => 'image/*', 'multiple' => true],
                'wrapper' => ['class' => 'mb-3'] // Add a CSS class to the wrapper div
            ])
            ->add('submit', 'submit', [
                'label' => 'Отправить',
                'attr' => ['class' => 'btn btn-primary'],
                'wrapper' => ['class' => 'mb-3'] // Add a CSS class to the wrapper div
            ]);
    }
}
