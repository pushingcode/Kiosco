<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;

class NuevoEjerForm extends Form
{
    public function buildForm()
    {
        $this
        ->add('conf', Field::HIDDEN, [
            'value' => $this->getData('model')
        ])
        ->add('inicio', Field::DATE, [
            'rules' => 'required'
        ])
        ->add('fin', Field::DATE, [
            'rules' => 'required'
        ])
        ->add('tipo', Field::SELECT, [
            'choices'  => [
                'regular'   => 'Regular', 
                'irregular' =>'Irregular'],
            'selected' => 'regular'
        ])
        ->add('estado', Field::SELECT, [
            'choices'  => [
                'abierto'   => 'Abierto', 
                'cerrado'   => 'Cerrado'],
            'selected' => 'abierto'
        ])
        ->add('submit', 'submit', [
            'attr'=>['class' => 'btn btn-success'], 
            'label' => 'Crear'
            ])
        ->add('clear', 'reset', [
            'attr'=>['class' => 'btn btn-danger'],
            'label' => 'Cancelar'
            ]);
    }
}
