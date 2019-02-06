<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;

use App\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\Gate;
use App\User;
use App\Ejercicio;

class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FormBuilder $formBuilder)
    {
        $user = User::find(Auth::id());
        //verificamos que la empresa este configurada
        $config = Config::all();
        foreach ($config as $cfgs){
            $myconfig = $cfgs->id;
        }
        
        //dd($config->isEmpty());
        if ($config->isEmpty()) {
            // la configuracon no se ha creado, enviammos un boton para conf
            $conf = false;
            $form = false;
            $fisc = false;
        } else {
            //verificamos si existe un ejercicio activo para la empresa
            $ejer = Ejercicio::all();//////////////////////////////
            if ($ejer->IsEmpty()) {
                //empresa creada sin ejercicio
                //enviamos los datos para un link
                if ($user->can('crear-ejercicio')) {
                    //enviamos form ConFiscForm
                    $fisc = $formBuilder->create(\App\Forms\ConFiscForm::class, [
                        'method' => 'GET',
                        'url' => route('ejercicio.create', $myconfig),
                    ], [
                        'accion' => 'crear',
                        'fiscal' => $myconfig
                        ]);
                    
                } else {
                    $fisc = 'no posee los permisos';
                }
            } else {
                //empresa creada con ejercicio
                //cargamos el ultimo ejercicio
                //verificamos si esta activo
                //verificamos si esta en fecha para cierre
            }

            $id   = "";
            $conf = $config;
            $form = $formBuilder->create(\App\Forms\ConfirmActionForm::class, [
                'method' => 'POST',
                'url' => '' //se deja vacio porque se trabajara con JQuery
            ]);
        }
        //dd($fisc);
        return view('admin.config', compact('fisc', 'conf', 'form'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Kris\LaravelFormBuilder\FormBuilder $formBuilder
     * @return \Illuminate\Http\Response
     */
    public function create(FormBuilder $formBuilder)
    {
        //permisos via roles
        $user = User::find(Auth::id());
        if (!$user->can('crear-empresa')) {
            return redirect()->back()->withErrors('Permisos insuficientes');
        }

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
    public function edit(FormBuilder $formBuilder, $id)
    {
        //
        //permisos via roles
        $user = User::find(Auth::id());
        if (!$user->can('editar-empresa')) {
            return redirect()->back()->withErrors('Permisos insuficientes');
        }

        $config = Config::find($id);

        if (!$config) {
            return redirect()->back()->withErrors('La empresa no existe');
        }

        $form = $formBuilder->create(\App\Forms\ConfigEmpresaForm::class, [
            'method'    => 'POST',
            'url'       => route('update.config', $id),
            'model'     => $config
        ], ['is_update' => true]);

        return view('admin.createConfig', compact('form'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Kris\LaravelFormBuilder\FormBuilder  formBuilder
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FormBuilder $formBuilder, $id)
    {
        //
        $form = $formBuilder->create(\App\Forms\ConfigEmpresaForm::class);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $input = $form->getFieldValues();

        $record = Config::find($id);

        $record->empresa    = $input['empresa'];
        $record->cuit       = $input['cuit'];
        $record->direccion  = $input['direccion'];
        $record->telefono   = $input['telefono'];

        $record->save();

        return redirect()->route('config', 302);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(FormBuilder $formBuilder, $id)
    {
        //permisos via roles
        $user = User::find(Auth::id());
        if (!$user->can('eliminar-empresa')) {
            return redirect()->back()->withErrors('Permisos insuficientes');
        }

        $form = $formBuilder->create(\App\Forms\ConfirmActionForm::class);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $input = $form->getFieldValues();

        if (!Hash::check($input['password'], Auth::user()->password)) {
            return redirect()->back()->withErrors('Password Incorrecto');
        }

        // espacio para capturar accion
        Config::destroy($id);

        return redirect()->back()->with('Empresa eliminada!!!');
    }
}
