<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;

class ConfigEmpresaForm extends Form
{
    public function buildForm()
    {
        // Add fields here...
        $this
            ->add('empresa', Field::TEXT, ['rules'=>'required|min:3'])
            ->add('cuit', Field::TEXT, ['rules'=>'required'])
            ->add('direccion', Field::TEXTAREA, ['rules'=>'required|min:3|max:100'])
            ->add('telefono', Field::TEXT, ['rules'=>'required']);
    }
}
