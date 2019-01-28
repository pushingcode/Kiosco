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
    @endif
@stop