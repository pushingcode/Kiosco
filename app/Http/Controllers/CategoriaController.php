<?php

namespace App\Http\Controllers;

use App\Categoria;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Hash;

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

        $form = $formBuilder->create(\App\Forms\NuevaCategoriaForm::class, [
            'method'    => 'POST',
            'url'       => route('categoria.store')
        ]);

        $categorias = Categoria::paginate(20);

        if ($categorias->isEmpty()) {
            $categorias = false;
        }

        $confirm = $formBuilder->create(\App\Forms\ConfirmActionForm::class, [
            'method'    => 'POST',
            'url'       => '' //se deja vacio porque se trabajara con JQuery
        ]);

        return view('admin.multiCategorias', compact('form', 'categorias', 'confirm'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
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
        $form = $formBuilder->create(\App\Forms\NuevaCategoriaForm::class);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $input = $form->getFieldValues();
        $record = new Categoria;
        $record->descripcion = $input['descripcion'];
        $record->codigo      = $input['codigo'];
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
        $categoria = Categoria::findOrFail($id);
        $categoria->toArray();
        $categorias = Categoria::paginate(20);
        $form = $formBuilder->create(\App\Forms\EditarCategoriaForm::class, [
            'method'    => 'POST',
            'url'       => route('categoria.update', $categoria['id'])
        ], [
            'model'         => $categoria['id'],
            'descripcion'   => $categoria['descripcion'],
            'codigo'        => $categoria['codigo']
        ]);

        $confirm = $formBuilder->create(\App\Forms\ConfirmActionForm::class, [
            'method'    => 'POST',
            'url'       => '' //se deja vacio porque se trabajara con JQuery
        ]);

        return view('admin.multiCategorias', compact('form', 'categorias', 'confirm'));
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

        $form = $formBuilder->create(\App\Forms\EditarCategoriaForm::class);
        $input = $form->getFieldValues();
        $categoria = Categoria::find($input['modelo']);
        $categoria->descripcion = $input['descripcion'];
        $categoria->codigo      = $input['codigo'];
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
        if (!$user->can('eliminar-empresa')) {
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
            ->withProperties(['accion' => 'eliminar categoria'])
            ->log('Validacion NO aprobada');

            return redirect()->back()->withErrors('Password Incorrecto');
        }

        Categoria::destroy($input['objeto']);
        return redirect()->route('categoria.index', [], 302);
    }
}
