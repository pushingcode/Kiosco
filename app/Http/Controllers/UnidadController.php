<?php

namespace App\Http\Controllers;

use App\Unidad;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use App\User;

class UnidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FormBuilder $formBuilder)
    {
        $user = User::find(Auth::id());
        if (!$user->can('ver-lista-producto')) {
            return redirect()->back()->withErrors('Permisos insuficientes');
        }

        $unidades = Unidad::paginate(15);
        //dd($unidades, $unidades->isEmpty());
        $form = $formBuilder->create(\App\Forms\NuevaUnidad::class, [
            'method'=>'POST',
            'url'=>route('unidad.store')
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
            'modo'  => false,
            'boton' => 'Crear Nueva Unidad'
        );

        return view('admin.multiUnidad', compact('form', 'unidades', 'confirm', 'collapsibleData'));
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
    public function store(Unidad $unidad, FormBuilder $formBuilder)
    {
        $user = User::find(Auth::id());
        if (!$user->can('crear-producto')) {
            return redirect()->back()->withErrors('Permisos insuficientes');
        }

        $form = $formBuilder->create(\App\Forms\NuevaUnidad::class);
        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $input = $form->getFieldValues();

        $record = new Unidad;

        $record->descripcionU   = $input['descripcion'];
        $record->unidad         = $input['unidad'];
        $record->unidadesL1     = $input['nivelL1'];
        $record->unidadesL2     = $input['nivelL2'];
        $record->divisible      = $input['divisible'];

        $record->save();

        return redirect()->route('unidad.index', [], 302);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Unidad  $unidad
     * @return \Illuminate\Http\Response
     */
    public function show(Unidad $unidad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Unidad  $unidad
     * @return \Illuminate\Http\Response
     */
    public function edit(FormBuilder $formBuilder, $id)
    {
        //

        $user = User::find(Auth::id());
        if (!$user->can('editar-producto')) {
            return redirect()->back()->withErrors('Permisos insuficientes');
        }

        $unidad = Unidad::findOrFail($id);
        $unidad = $unidad->toArray();
        $unidades = Unidad::paginate(15);
        $form = $formBuilder->create(\App\Forms\EditarUnidadForm::class, [
            'method'    => 'POST',
            'url'       => route('unidad.update', $unidad['id'])
        ], [
            'model'         => $unidad['id'],
            'descripcion'  => $unidad['descripcionU'],
            'unidad'        => $unidad['unidad'],
            'unidadL1'      => $unidad['unidadesL1'],
            'unidadL2'      => $unidad['unidadesL2'],
            'divisible'     => $unidad['divisible']
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
            'boton' => 'Editar unidad'
        );

        return view('admin.multiUnidad', compact('form', 'unidades', 'confirm', 'collapsibleData'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Unidad  $unidad
     * @return \Illuminate\Http\Response
     */
    public function update(Unidad $unidad, FormBuilder $formBuilder)
    {
        //
        $user = User::find(Auth::id());
        if (!$user->can('editar-producto')) {
            return redirect()->back()->withErrors('Permisos insuficientes');
        }

        $form = $formBuilder->create(\App\Forms\EditarUnidadForm::class);
        $input = $form->getFieldValues();
        $record = Unidad::find($input['modelo']);
        $record->descripcionU   = $input['descripcion'];
        $record->unidad         = $input['unidad'];
        $record->unidadesL1     = $input['nivelL1'];
        $record->unidadesL2     = $input['nivelL2'];
        $record->divisible      = $input['divisible'];
        $record->save();

        return redirect()->route('unidad.index', [], 302);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Unidad  $unidad
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unidad $unidad, FormBuilder $formBuilder)
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
            ->performedOn($unidad)
            ->causedBy($user)
            ->withProperties(['accion' => 'eliminar categoria'])
            ->log('Validacion NO aprobada');

            return redirect()->back()->withErrors('Password Incorrecto');
        }

        Unidad::destroy($input['objeto']);
        return redirect()->route('unidad.index', [], 302);

    }
}
