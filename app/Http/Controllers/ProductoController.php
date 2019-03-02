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

        $categoria = Categoria::select('id', 'descripcion')->get();
        $categoria = $categoria->toArray();
        foreach ($categoria as $interno) {
            $data[$interno['id']] = $interno['descripcion'];
        }

        $unidad = Unidad::select('id', 'descripcion')->get();
        $unidad = $unidad->toArray();
        foreach ($unidad as $interno) {
            $dato[$interno['id']] = $interno['descripcion'];
        }

        $form = $formBuilder->create(\App\Forms\NuevoProductoForm::class, [
            'method'    => 'POST',
            'url'       => route('categoria.store')
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
    public function store(Request $request)
    {
        //
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
