<?php

namespace App\Http\Controllers;

use App\Categoria;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

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

        //dd($categorias, $form, $user->can('crear-producto'));

        return view('admin.multiCategorias', compact('form', 'categorias'));
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

        return redirect()->route('categoria.index', 302);

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
    public function edit(Categoria $categoria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Categoria $categoria)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categoria $categoria)
    {
        //
    }
}
