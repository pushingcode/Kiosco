@extends('adminlte::page')

@section('title', 'Configuracion General')

@section('content_header')
    <h1>Datos de Configuracion</h1>
@stop

@section('content')
    <p></p>
    @if ($conf === false)
    <p><a href="{{ url('admin/config/create') }}">Crear Configuracion Inicial</a></p>
    @else
    <table class="table">
    <thead>
        <tr>
        <th scope="col">#</th>
        <th scope="col">Empresa</th>
        <th scope="col">CUIT</th>
        <th scope="col">Telefono</th>
        <th scope="col">Ejercicio</th>
        <th scope="col">Opciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($conf as $empresa)
            <tr>
            <th scope="row">{{ $empresa->id }}</th>
            <td>{{ $empresa->empresa }}</td>
            <td>{{ $empresa->cuit }}</td>
            <td>{{ $empresa->telefono }}</td>
            <td>
            <div class="btn-group" role="group">
            <a role="button" class="btn btn-primary" href="{{ url('admin/config/create') }}">Crear</a>
            <a role="button" class="btn btn-danger" href="{{ url('admin/config/create') }}">ver</a>
            </div>
            </td>
            <td>
            <div class="btn-group" role="group">
            <a role="button" class="btn btn-primary" href="{{ url('admin/config/create') }}">Editar</a>
            <a role="button" class="btn btn-danger" href="{{ url('admin/config/create') }}">Eliminar</a>
            </div>
            </td>
            </tr>
        @endforeach
    </tbody>
    </table>
    @endif
@stop