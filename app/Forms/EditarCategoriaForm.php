<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;

class EditarCategoriaForm extends Form
{
    public function buildForm()
    {
        // Add fields here...
        $this
        ->add('_method', 'hidden', [
            'value' => 'PUT'
        ])
        ->add('modelo', 'hidden', [
            'value'=> $this->getData('model')
        ])
        ->add('descripcion', Field::TEXT, [
            'value'=> $this->getData('descripcion'),
            'rules'=> 'required'
        ])
        ->add('codigo', Field::TEXT, [
            'value'=> $this->getData('codigo'),
            'rules'=> 'required'
        ])
        ->add('submit', 'submit', [
            'attr'  => ['class' => 'btn btn-success'], 
            'label' => 'Actualizar'
            ])
        ->add('clear', 'reset', [
            'attr'  => ['class' => 'btn btn-danger'],
            'label' => 'Cancelar'
            ]);
    }
}
