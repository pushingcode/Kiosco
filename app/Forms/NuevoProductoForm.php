<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;

class NuevoProductoForm extends Form
{
    public function buildForm()
    {
        // Add fields here...
        $this
        ->add('categoria', Field::SELECT, [
            'choices'  => $this->getData('categoria'),
            'selected' =>  'Seleccione'
        ])
        ->add('unidad', Field::SELECT, [
            'choices'  => $this->getData('unidad'),
            'selected' => 'Seleccione'
        ])
        ->add('descripcion', Field::TEXT, [
            'rules'=>'required'
        ])
        ->add('marca', Field::TEXT, [
            'rules'=>'required'
        ])
        ->add('codigo', Field::TEXT, [
            'rules'=>'required'
        ])
        ->add('sku', Field::TEXT, [
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
