<?php

namespace App\Http\Controllers;


use Kris\LaravelFormBuilder\FormBuilder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Producto;
use App\Categoria;
use App\Unidad;
use App\User;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FormBuilder $formBuilder)
    {
        //preparamos el form
        $user = User::find(Auth::id());
        if (!$user->can('ver-lista-producto')) {
            return redirect()->back()->withErrors('Permisos insuficientes');
        }

        $productos = Producto::paginate(15);
        if ($productos->isEmpty()) {
            $productos = false;
        }
        $data = array();
        $dato = array();

        $categoria = Categoria::select('id', 'descripcionC')->get();
        $categoria = $categoria->toArray();
        foreach ($categoria as $interno) {
            $data[$interno['id']] = $interno['descripcionC'];
        }

        $unidad = Unidad::select('id', 'descripcionU')->get();
        $unidad = $unidad->toArray();
        foreach ($unidad as $interno) {
            $dato[$interno['id']] = $interno['descripcionU'];
        }

        $form = $formBuilder->create(\App\Forms\NuevoProductoForm::class, [
            'method'    => 'POST',
            'url'       => route('producto.store')
        ], [
            'categoria' => $data,
            'unidad'    => $dato
        ]);

        $confirm = $formBuilder->create(\App\Forms\ConfirmActionForm::class, [
            'method'    => 'POST',
            'url'       => '' //se deja vacio porque se trabajara con JQuery
        ]);

        // configurando collapsible
        $collapsibleData = array(
            'modo'  => false,
            'boton' => 'Crear Nuevo Producto'
        );

        return view('admin.multiProductos', compact('form', 'productos', 'confirm', 'collapsibleData'));

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

        $form = $formBuilder->create(\App\Forms\NuevoProductoForm::class);
        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }
        $input = $form->getFieldValues();
        $record = new Producto;
        $record->categorias_id = $input['categoria'];
        $record->unidads_id = $input['unidad'];
        $record->descripcionP = $input['descripcion'];
        $record->marca = $input['marca'];
        $record->codigoP = $input['codigo'];
        $record->sku = $input['sku'];
        $record->save();

        return redirect()->route('producto.index', [], 302);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function show(Producto $producto)
    {
        //
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function edit(Producto $producto, FormBuilder $formBuilder)
    {
        //
        $user = User::find(Auth::id());
        if (!$user->can('editar-producto')) {
            return redirect()->back()->withErrors('Permisos insuficientes');
        }


        $data = array();
        $dato = array();

        $categoria = Categoria::select('id', 'descripcionC')->get();
        $categoria = $categoria->toArray();
        foreach ($categoria as $interno) {
            $data[$interno['id']] = $interno['descripcionC'];
        }

        $unidad = Unidad::select('id', 'descripcionU')->get();
        $unidad = $unidad->toArray();
        foreach ($unidad as $interno) {
            $dato[$interno['id']] = $interno['descripcionU'];
        }

        $productoA = Producto::find($producto->id);
        $productoA->with('categoria', 'unidad');
        $form = $formBuilder->create(\App\Forms\EditarProductoFrom::class, [
            'method'    =>'POST',
            'url'       =>route('producto.update', $producto->id)
        ], [
            'modelo'        => $producto->id,
            'categoriaID'   => $producto->categoria->id,
            'unidadID'      => $producto->unidad->id,
            'descripcion'   => $producto->descripcionP,
            'marca'         => $producto->marca,
            'codigoP'       => $producto->codigoP,
            'sku'           => $producto->sku,
            'categoria'     => $data,
            'unidad'        => $dato
        ]);

        $confirm = $formBuilder->create(\App\Forms\ConfirmActionForm::class, [
            'method'    => 'POST',
            'url'       => '' //se deja vacio porque se trabajara con JQuery
        ]);

        $productos = Producto::paginate(15);
        if ($productos->isEmpty()) {
            $productos = false;
        }
        /**
         * Configuracion de collapsible
         * true = collapsible abierto para edit
         * false = collapsible cerrado para index
         */
        $collapsibleData = array(
            'modo'  => true,
            'boton' => 'Editar Producto'
        ); 
        return view('admin.multiProductos', compact('form', 'productos', 'confirm', 'collapsibleData'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function update(Producto $producto, FormBuilder $formBuilder)
    {
        //
        $user = User::find(Auth::id());
        if (!$user->can('editar-producto')) {
            return redirect()->back()->withErrors('Permisos insuficientes');
        }

        $form = $formBuilder->create(\App\Forms\EditarProductoFrom::class);
        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $input = $form->getFieldValues();

        $record = Producto::find($producto->id);
        $record->categorias_id = $input['categoria'];
        $record->unidads_id = $input['unidad'];
        $record->descripcionP = $input['descripcion'];
        $record->marca = $input['marca'];
        $record->codigoP = $input['codigo'];
        $record->sku = $input['sku'];
        $record->save();

        return redirect()->route('producto.index', [], 302);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Producto $producto, FormBuilder $formBuilder)
    {
        //
        $user = User::find(Auth::id());
        if (!$user->can('eliminar-producto')) {
            return redirect()->back()->withErrors('Permisos insuficientes');
        }

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
            ->performedOn($producto)
            ->causedBy($user)
            ->withProperties(['accion' => 'Eliminar producto '. $producto->descripcionP])
            ->log('Validacion NO aprobada');

            return redirect()->back()->withErrors('Password Incorrecto');
        }

        Categoria::destroy($producto->id);
        return redirect()->route('producto.index', [], 302);
    }
}
