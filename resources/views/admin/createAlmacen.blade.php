@extends('adminlte::page')

@section('title', 'Creacion de Almacen')

@section('content_header')
    <h1>Creacion de Almacen</h1>
@stop

@section('content')

@include('flash')
    
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
<script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    <script>
    /*
    * void
    */
    </script>
@stop
  