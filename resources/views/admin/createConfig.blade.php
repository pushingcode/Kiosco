@extends('adminlte::page')

@section('title', 'Configuracion de Ejercicio Economico')

@section('content_header')
    <h1>Datos de Configuracion</h1>
@stop

@section('content')
    
    <div class="row">
        <div class="col-sm-8">

        {!! form($form) !!}

        </div>
        <div class="col-sm-4">
        <h3>Dato importante</h3>
        @isset($decript)
            <p>{{ $decript }}</p>
        @endisset

        </div>
    </div>


@stop

@section('adminlte_js')
<script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    <script>
    /*
    * ajuste de 12 meses para el form
    */
        $("#inicio").change(function(){
            var inicio = new Date($(this).val());
            inicio.setMonth(13);
            var fin = new Date(inicio);
            var fin = fin.toISOString().slice(0,10);
            $("#fin").val(fin);
        });
    </script>
@stop
  