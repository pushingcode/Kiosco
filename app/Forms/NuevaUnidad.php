<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;

class NuevaUnidad extends Form
{
    public function buildForm()
    {
        // Add fields here...
        $this
        ->add('descripcion', Field::TEXT, [
            'rules'=>'required'
        ])
        ->add('unidad', Field::TEXT, [
            'rules'=>'required'
        ])
        ->add('nivelL1', Field::TEXT, [
            'rules'=>'required'
        ])
        ->add('nivelL2', Field::TEXT, [
            'rules'=>'required'
        ])
        ->add('divisible', Field::SELECT, [
            'choices'  => [
                'si'        => 'Si', 
                'no'        => 'No'],
            'selected' => 'si'
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
