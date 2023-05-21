<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class CategoryForm extends Form
{
    /**
     * @return void
     */
    public function buildForm(): void
    {
        $this
            ->add('name', 'text', [
                'rules' => 'required'
            ])
            ->add('submit', 'submit')
        ;
    }
}
