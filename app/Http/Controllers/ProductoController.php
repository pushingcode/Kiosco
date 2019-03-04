<?php

namespace App\Http\Controllers;

use App\Producto;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use App\Categoria;
use App\Unidad;

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

        return view('admin.multiProductos', compact('form', 'productos', 'confirm'));

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
    public function edit(Producto $producto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Producto $producto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Producto $producto)
    {
        //
    }
}
