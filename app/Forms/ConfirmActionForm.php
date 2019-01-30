<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class ConfirmActionForm extends Form
{
    public function buildForm()
    {
        // Add fields here...
        $this
            ->add('objeto', 'hidden')
            ->add('accion', 'hidden')
            ->add('password', 'password')
            ->add('submit', 'submit', ['label' => 'Eliminar']);
    }
}
