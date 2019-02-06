<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class ConFiscForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('conf', 'hidden', [
                'value' => $this->getData('fiscal')
            ]);

        if ($this->getData('accion') == 'crear') {
            $this->add('submit', 'submit', [
                'attr' => ['class' => 'btn btn-success btn-sm'],
                'label' => 'Crear'
            ]);
        }

        if ($this->getData('accion') == 'gestionar') {
            $this->add('submit', 'submit', [
                'attr' => ['class' => 'btn btn-warning btn-sm'],
                'label' => 'Ver/Cerrar'
            ]);
        }
    }
}
