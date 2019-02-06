<?php

namespace App\Http\Controllers;

use App\Ejercicio;
use App\User;
use App\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\Gate;
use Kris\LaravelFormBuilder\FormBuilder;

class EjercicioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Kris\LaravelFormBuilder\FormBuilder  $formBuilder
     * @return \Illuminate\Http\Response
     */
    public function create(FormBuilder $formBuilder)
    {
        //permisos
        $user = User::find(Auth::id());
        if (!$user->can('crear-ejercicio')) {
            return redirect()->back()->withErrors('Permisos insuficientes');
        }

        $form = $formBuilder->create(\App\Forms\ConFiscForm::class);

        $input = $form->getFieldValues();
        $model = Config::find($input['conf']);
        //dd($model);
        unset($form);
        
        $form = $formBuilder->create(\App\Forms\NuevoEjerForm::class, [
            'method' => 'POST',
            'model' => $model,
            'url' => route('ejercicio.store')
        ]);

        return view('admin.createConfig', compact('form'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ejercicio  $ejercicio
     * @return \Illuminate\Http\Response
     */
    public function show(Ejercicio $ejercicio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ejercicio  $ejercicio
     * @return \Illuminate\Http\Response
     */
    public function edit(Ejercicio $ejercicio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ejercicio  $ejercicio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ejercicio $ejercicio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ejercicio  $ejercicio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ejercicio $ejercicio)
    {
        //
    }
}
