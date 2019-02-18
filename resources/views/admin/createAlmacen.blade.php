@extends('adminlte::page')

@section('title', 'Creacion de Almacen')

@section('content_header')
    <h1>Creacion de Almacen</h1>
@stop

@section('content')
    
    <div class="row">
        <div class="col-sm-8">

        {!! form($form) !!}

        </div>
        <div class="col-sm-4">
            <h3>Dato importante</h3>
        </div>
    </div>


@stop

@section('adminlte_js')
    <script>
    /*
    * void
    */
    </script>
@stop
  