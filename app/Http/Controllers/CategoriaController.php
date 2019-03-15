<?php

namespace App\Http\Controllers;


use Kris\LaravelFormBuilder\FormBuilder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Categoria;
use App\User;

class CategoriaController extends Controller
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
        if (!$user->can('ver-lista-producto')) {
            return redirect()->back()->withErrors('Permisos insuficientes');
        }

        $form = $formBuilder->create(\App\Forms\NuevaCategoriaForm::class, [
            'method'    => 'POST',
            'url'       => route('categoria.store')
        ]);

        $categorias = Categoria::paginate(5);

        if ($categorias->isEmpty()) {
            $categorias = false;
        }

        $confirm = $formBuilder->create(\App\Forms\ConfirmActionForm::class, [
            'method'    => 'POST',
            'url'       => '' //se deja vacio porque se trabajara con JQuery
        ]);

        /**
         * Configuracion de collapsible
         * true = collapsible abierto para edit
         * false = collapsible cerrado para index
         */
        $collapsibleData = array(
            'modo'  => false,
            'boton' => 'Crear Nueva Categoria'
        );

        return view('admin.multiCategorias', compact('form', 'categorias', 'confirm', 'collapsibleData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $user = User::find(Auth::id());
        if (!$user->can('crear-producto')) {
            return redirect()->back()->withErrors('Permisos insuficientes');
        }
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
        if (!$user->can('crear-producto')) {
            return redirect()->back()->withErrors('Permisos insuficientes');
        }

        $form = $formBuilder->create(\App\Forms\NuevaCategoriaForm::class);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $input = $form->getFieldValues();
        $record = new Categoria;
        $record->descripcionC = $input['descripcion'];
        $record->codigoC      = $input['codigo'];
        $record->save();

        return redirect()->route('categoria.index', [], 302);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function show(Categoria $categoria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function edit(FormBuilder $formBuilder, $id)
    {
        //
        $user = User::find(Auth::id());
        if (!$user->can('editar-producto')) {
            return redirect()->back()->withErrors('Permisos insuficientes');
        }
        
        $categoria = Categoria::findOrFail($id);
        $categoria->toArray();
        $categorias = Categoria::paginate(5);
        $form = $formBuilder->create(\App\Forms\EditarCategoriaForm::class, [
            'method'    => 'POST',
            'url'       => route('categoria.update', $categoria['id'])
        ], [
            'model'         => $categoria['id'],
            'descripcion'   => $categoria['descripcionC'],
            'codigo'        => $categoria['codigoC']
        ]);

        $confirm = $formBuilder->create(\App\Forms\ConfirmActionForm::class, [
            'method'    => 'POST',
            'url'       => '' //se deja vacio porque se trabajara con JQuery
        ]);

        /**
         * Configuracion de collapsible
         * true = collapsible abierto para edit
         * false = collapsible cerrado para index
         */
        $collapsibleData = array(
            'modo'  => true,
            'boton' => 'Editar Categoria'
        );

        return view('admin.multiCategorias', compact('form', 'categorias', 'confirm', 'collapsibleData'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function update(Categoria $categoria, FormBuilder $formBuilder)
    {
        //
        $user = User::find(Auth::id());
        if (!$user->can('editar-producto')) {
            return redirect()->back()->withErrors('Permisos insuficientes');
        }

        $form = $formBuilder->create(\App\Forms\EditarCategoriaForm::class);
        $input = $form->getFieldValues();
        $categoria = Categoria::find($input['modelo']);
        $categoria->descripcionC = $input['descripcion'];
        $categoria->codigoC      = $input['codigo'];
        $categoria->save();

        return redirect()->route('categoria.index', [], 302);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categoria $categoria, FormBuilder $formBuilder)
    {
        $user = User::find(Auth::id());
        if (!$user->can('eliminar-producto')) {
            return redirect()->back()->withErrors('Permisos insuficientes');
        }
        
        $form = $formBuilder->create(\App\Forms\ConfirmActionForm::class);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $input = $form->getFieldValues();

        if (!Hash::check($input['password'], Auth::user()->password)) {

            activity('danger')
            ->performedOn($categoria)
            ->causedBy($user)
            ->withProperties(['accion' => 'Eliminar categoria '. $categoria->descripcionC])
            ->log('Validacion NO aprobada');

            return redirect()->back()->withErrors('Password Incorrecto');
        }

        Categoria::destroy($categoria->id);
        return redirect()->route('categoria.index', [], 302);
    }
}
