<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class ConfirmActionForm extends Form
{
    //protected $name = 'DeleteEmpresa';

    public function buildForm()
    {
        // Add fields here...
        $this
            ->add('objeto', 'hidden', [
                'value' => 'n/a',
                'attr' => ['id' => 'objeto']
                ])
            ->add('accion', 'hidden', [
                'value' => 'n/a',
                'attr' => ['id' => 'accion']
                ])
                ->add('_method', 'hidden', [
                    'value' => 'DELETE'
                ])
            ->add('password', 'password', ['rules'=>'required'])
            ->add('submit', 'submit', [
                'attr'=>['class' => 'btn btn-danger'], 
                'label' => 'Procesar'
                ])
            ->add('clear', 'reset', [
                'attr'=>['class' => 'btn btn-light', 'data-dismiss' => 'modal'],
                'label' => 'Cancelar'
                ]);
    }
}
