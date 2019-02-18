<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;

class NuevoAlmacenForm extends Form
{
    public function buildForm()
    {
        $this
        ->add('id', Field::HIDDEN, [
            'value' => $this->getData('model')
            ])
        ->add('nombre', Field::TEXT, [
            'rules'=>'required'
            ])
        ->add('codigo', Field::TEXT, [
            'value' => $this->getData('codigo'),
            'rules' => 'required'
        ])
        ->add('notas', Field::TEXTAREA, [
            'rules' => 'max:150'
        ])
        ->add('direccion', Field::TEXTAREA, [
            'value' => $this->getData('direccion'),
            'rules' => 'required'
        ])
        ->add('estado', Field::SELECT, [
            'choices'  => [
                'activo'     => 'Activo', 
                'inactivo'   => 'Inactivo'],
            'selected' => 'activo'
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
