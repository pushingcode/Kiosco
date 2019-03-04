<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;

class EditarProductoFrom extends Form
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
        ->add('categoria', Field::SELECT, [
            'choices'  => $this->getData('categoria'),
            'selected' =>  $this->getData('categoriaID')
        ])
        ->add('unidad', Field::SELECT, [
            'choices'  => $this->getData('unidad'),
            'selected' => $this->getData('unidadID')
        ])
        ->add('descripcion', Field::TEXT, [
            'value'=>$this->getData('descripcion'),
            'rules'=>'required'
        ])
        ->add('marca', Field::TEXT, [
            'value'=>$this->getData('marca'),
            'rules'=>'required'
        ])
        ->add('codigo', Field::TEXT, [
            'value'=>$this->getData('codigoP'),
            'rules'=>'required'
        ])
        ->add('sku', Field::TEXT, [
            'value'=>$this->getData('sku'),
            'rules'=>'required'
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
