@extends('adminlte::page')

@section('title', 'Categorias')

@section('content_header')
    <h1>Datos de Configuracion</h1>
@stop

@section('content')
    
    <div class="row">
        <div class="col-sm-8">
        @if($form == false)
        @else
            {!! form($form) !!}
        @endif
        <hr>
        @if($categorias)
            <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Descripcion</th>
                    <th>Codigo</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categorias as $categoria)
                <tr>
                    <td>{{ $categoria->id }}</td>
                    <td>{{ $categoria->descripcion }}</td>
                    <td>{{ $categoria->codigo }}</td>
                    <td><i class="fas fa-pen-square"></i> <i class="fas fa-trash-alt"></i></td>
                </tr>
                @endforeach
            </tbody>
            </table>
            {{ $categorias->links() }}
        @endif
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
    <script>
    /*
    * ajuste de 12 meses para el form
    */
    </script>
@stop