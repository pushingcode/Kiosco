@extends('adminlte::page')

@section('title', 'Ejercicios Economicos')

@section('content_header')
    <h1>Lista de Ejercicios Economicos Realizados</h1>
@stop

@section('content')
    <table class="table">
        <thead>
        <tr>
            <th>Inicio</th>
            <th>Fin</th>
            <th>Tipo</th>
            <th>Estado</th>
            <th>Estadisticas</th>
            <th>Operaciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach($ejercicios as $ejercicio)
        <tr>
            <td>{{ $ejercicio->inicio }}</td>
            <td>{{ $ejercicio->fin }}</td>
            <td>{{ $ejercicio->tipo }}</td>
            <td>{{ $ejercicio->estado }}</td>
            <td>Estadisticas ejercicio</td>
            <td>
                @if($ejercicio->estado === 'abierto')
                <a role="button" class="btn btn-info btn-sm" href="#">Cerrar</a>
                @else
                CERRADO
                @endif
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
@stop

@section('adminlte_js')
    <script>
        //void
    </script>
@stop