<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;

class EditarProveedorForm extends Form
{
    public function buildForm()
    {
        // Add fields here...
        $this
        ->add('_method', 'hidden', [
            'value' => 'PUT'
        ])
        ->add('modelo', Field::HIDDEN, [
            'value'=>$this->getData('modelo')
        ])
        ->add('empresa', Field::TEXT, [
            'value'=>$this->getData('empresa'),
            'rules'=>'required|min:3'
            ])
        ->add('cuit', Field::TEXT, [
            'value'=>$this->getData('cuit'),
            'rules'=>'required'
            ])
        ->add('direccion', Field::TEXTAREA, [
            'value'=>$this->getData('direccion'),
            'rules'=>'required|min:3|max:100'
            ])
        ->add('telefono', Field::TEXT, [
            'value'=>$this->getData('telefono'),
            'rules'=>'required'
            ])
        ->add('email', Field::TEXT, [
            'value'=>$this->getData('email'),
            'rules'=>'required|email'
            ])
        ->add('estado', Field::SELECT, [
            'choices'  => [
                'activo'     => 'Activo', 
                'inactivo'   => 'Inactivo'],
            'selected' => $this->getData('estado')
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
