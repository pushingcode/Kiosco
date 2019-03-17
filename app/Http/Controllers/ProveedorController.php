<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kris\LaravelFormBuilder\FormBuilder;
use App\User;
use App\Proveedor;
use Kris\LaravelFormBuilder\Form;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FormBuilder $formBuilder)
    {
        //
        $user = User::find(Auth::id());
        if (!$user->can('ver-lista-proveedor')) {
            return redirect()->back()->withErrors('Permisos insuficientes');
        }

        $proveedores = Proveedor::paginate(15);
        if ($proveedores->isEmpty()) {
            $proveedores = false;
        }
        $form = $formBuilder->create(\App\Forms\NuevoProveedor::class, [
            'method'    => 'POST',
            'url'       => route('proveedor.store')
        ]);

        $confirm = $formBuilder->create(\App\Forms\ConfirmActionForm::class, [
            'method'    => 'POST',
            'url'       => '' //se deja vacio porque se trabajara con JQuery
        ]);

        // configurando collapsible
        $collapsibleData = array(
            'modo'  => false,
            'boton' => 'Crear Nuevo Proveedor'
        );

        return view('admin.multiProveedores', compact('form', 'proveedores', 'confirm', 'collapsibleData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * php artisan make:form  Forms/NuevoProveedor
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FormBuilder $formBuilder)
    {
        //
        $user = User::find(Auth::id());
        if (!$user->can('crear-proveedor')) {
            return redirect()->back()->withErrors('Permisos insuficientes');
        } 

        $form = $formBuilder->create(\App\Forms\NuevoProveedor::class);
        if (!$form->isValid()) {
            $collapsibleData = array(
                'modo'  => true,
                'boton' => 'Crear Nuevo Producto'
            );
            return redirect()
            ->back()
            ->withErrors($form->getErrors())
            ->withInput()
            ->with('collapsibleData');
        }

        $input = $form->getFieldValues();
        $record = new Proveedor;
        $record->empresa    = $input['empresa'];
        $record->cuit       = $input['cuit'];
        $record->direccion  = $input['direccion'];
        $record->telefono   = $input['telefono'];
        $record->email      = $input['email'];
        $record->save();

        return redirect()->route('proveedor.index', [], 302);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function show(Proveedor $proveedor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function edit(Proveedor $proveedor, FormBuilder $formBuilder)
    {
        //
        $user = User::find(Auth::id());
        if (!$user->can('editar-proveedor')) {
            return redirect()->back()->withErrors('Permisos insuficientes');
        }
        $proveedor = Proveedor::find($proveedor->id);
        $form = $formBuilder->create(\App\Forms\EditarProveedorForm::class, [
            'method'    => 'POST',
            'url'       => route('proveedor.update', $proveedor->id)
        ], [
            'modelo'    => $proveedor->id,
            'empresa'   => $proveedor->empresa,
            'cuit'      => $proveedor->cuit,
            'direccion' => $proveedor->direccion,
            'telefono'  => $proveedor->telefono,
            'email'     => $proveedor->email,
            'estado'    => $proveedor->estado
        ]);

        $confirm = $formBuilder->create(\App\Forms\ConfirmActionForm::class, [
            'method'    => 'POST',
            'url'       => '' //se deja vacio porque se trabajara con JQuery
        ]);

        $proveedores = Proveedor::paginate(15);
        if ($proveedores->isEmpty()) {
            $proveedores = false;
        }

        /**
         * Configuracion de collapsible
         * true = collapsible abierto para edit
         * false = collapsible cerrado para index
         */
        $collapsibleData = array(
            'modo'  => true,
            'boton' => 'Editar Proveedor'
        ); 
        return view('admin.multiProveedores', compact('form', 'proveedores', 'confirm', 'collapsibleData'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proveedor $proveedor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proveedor $proveedor)
    {
        //
    }
}
