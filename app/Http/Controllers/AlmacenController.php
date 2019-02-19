<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Config;
use App\Almacen;

class AlmacenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FormBuilder $formBuilder)
    {
        //
        $almacenes = Almacen::all();

        $form = $formBuilder->create(\App\Forms\ConfirmActionForm::class, [
            'method'    => 'POST',
            'url'       => '' //se deja vacio porque se trabajara con JQuery
        ]);

        return view('admin.almacenes', compact('almacenes', 'form'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Kris\LaravelFormBuilder\FormBuilder  formBuilder
     * @return \Illuminate\Http\Response
     */
    public function create(FormBuilder $formBuilder)
    {
        //
        $user = User::find(Auth::id());
        if (!$user->can('crear-empresa')) {
            return redirect()->back()->withErrors('Permisos insuficientes');
        }
        $store = Config::first();
        $myStore = $store->toArray();
        $storage = Almacen::all();

        if ($storage->isEmpty()) {
            $codigo = str_pad(1, 5, "0", STR_PAD_LEFT);
        } else {
            $cod = $storage->count() + 1;
            $codigo = str_pad($cod, 5, "0", STR_PAD_LEFT);
        }

        $form = $formBuilder->create(\App\Forms\NuevoAlmacenForm::class, [
            'method' => 'POST',
            'url' => route('almacen.store')
        ], [
            'model'         => $myStore['id'],
            'codigo'        => $codigo,
            'direccion'     => $myStore['direccion']
        ]);

        return view('admin.createAlmacen', compact('form'));
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
        $form = $formBuilder->create(\App\Forms\NuevoAlmacenForm::class);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }
        $input = $form->getFieldValues();

        $record = new Almacen;
        $record->empresa_id = $input['id'];
        $record->nombre = $input['nombre'];
        $record->codigo = $input['codigo'];
        $record->notas = $input['notas'];
        $record->direccion = $input['direccion'];
        $record->estado = $input['estado'];

        $record->save();

        return redirect()->route('almacen.index', 302);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Almacen  $almacen
     * @return \Illuminate\Http\Response
     */
    public function show(Almacen $almacen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Almacen  $almacen
     * @return \Illuminate\Http\Response
     */
    public function edit(Almacen $almacen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Almacen  $almacen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Almacen $almacen)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Almacen  $almacen
     * @return \Illuminate\Http\Response
     */
    public function destroy(Almacen $almacen, FormBuilder $formBuilder)
    {
        //
        
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

        $almacen->estado = 'inactivo';
        $almacen->save();
        return redirect()->route('almacen.index', 302);
    }
}
