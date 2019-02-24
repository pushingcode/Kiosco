<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;

class NuevaCategoriaForm extends Form
{
    public function buildForm()
    {
        $this
        ->add('descripcion', Field::TEXT, [
            'rules'=>'required'
        ])
        ->add('codigo', Field::TEXT, [
            'rules'=>'required'
        ])
        ->add('submit', 'submit', [
            'attr'  => ['class' => 'btn btn-success'], 
            'label' => 'Crear'
            ])
        ->add('clear', 'reset', [
            'attr'  => ['class' => 'btn btn-danger'],
            'label' => 'Cancelar'
            ]);
    }
}
