<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;

class EditarUnidadForm extends Form
{
    public function buildForm()
    {
        $this
        ->add('_method', 'hidden', [
            'value' => 'PUT'
        ])
        ->add('modelo', Field::HIDDEN, [
            'value'=>$this->getData('model')
        ])
        ->add('descripcion', Field::TEXT, [
            'value'=>$this->getData('descripcion'),
            'rules'=>'required'
        ])
        ->add('unidad', Field::TEXT, [
            'value'=>$this->getData('unidad'),
            'rules'=>'required'
        ])
        ->add('nivelL1', Field::TEXT, [
            'value'=>$this->getData('unidadL1'),
            'rules'=>'required'
        ])
        ->add('nivelL2', Field::TEXT, [
            'value'=>$this->getData('unidadL2'),
            'rules'=>'required'
        ])
        ->add('divisible', Field::SELECT, [
            'choices'  => [
                'si'        => 'Si', 
                'no'        => 'No'],
            'selected' => $this->getData('divisible')
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
