<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;

use App\Config;

class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //verificamos que la empresa este configurada
        $config = Config::all();
        //dd($config->isEmpty());
        if ($config->isEmpty()) {
            # la configuracon no se ha creado, enviammos un boton para conf
            $conf = false;
        } else {
            $conf = $config;
        }
        
        return view('admin.config', compact('conf'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(\App\Forms\ConfigEmpresaForm::class, [
            'method' => 'POST',
            'url' => route('store.config')
        ]);

        return view('admin.createConfig', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Kris\LaravelFormBuilder\FormBuilder  formBuilder
     * @return \Illuminate\Http\Response
     */
    public function store(FormBuilder $formBuilder)
    {
        //
        
        $form = $formBuilder->create(\App\Forms\ConfigEmpresaForm::class);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $input = $form->getFieldValues();

        $record = new Config;

        $record->empresa    = $input['empresa'];
        $record->cuit       = $input['cuit'];
        $record->direccion  = $input['direccion'];
        $record->telefono   = $input['telefono'];

        $record->save();

        return redirect()->route('config', 302);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
