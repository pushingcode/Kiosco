<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use Illuminate\Support\Facades\Auth;
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
    public function index()
    {
        //
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
        $cod = "1";
        if ($storage->isEmpty()) {
            $codigo = str_pad($cod, 4, "0", STR_PAD_LEFT);
        } else {
            $cod = strlen($storage->count() + 1);
            $fill = 5 - $cod;
            $codigo = str_pad($cod, $fill, "0", STR_PAD_LEFT);
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

        return redirect()->route('/almacen', 302);
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
    public function destroy(Almacen $almacen)
    {
        //
    }
}
