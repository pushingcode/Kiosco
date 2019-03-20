@extends('adminlte::page')

@section('title', 'Ejercicios Economicos')

@section('content_header')
    <h1>Lista de Ejercicios Economicos Realizados</h1>
@stop

@section('content')
@include('flash')
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
            <td>
                @if($ejercicio->estado == 'abierto')
                    <span class="label label-success">{{ $ejercicio->estado }}</span>
                @else
                    <span class="label label-secondary">{{ $ejercicio->estado }}</span>
                @endif
            </td>
            <td>Estadisticas ejercicio</td>
            <td>
                @if($ejercicio->estado === 'abierto')
                <a id="cerrar-ejercicio" role="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#deltFisc" data-objetivo="{{ $ejercicio->id }}" data-accion="{{ url('ejercicio/'. $ejercicio->id ) }}" href="#">Cerrar</a>
                @else
                CERRADO
                @endif
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    <!-- Modal -->
    <div class="modal fade" id="deltFisc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">Verificacion Requerida</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4>Esta por cerrar este Ejercicio Economico!</h4>
                    <p>Ingrese su Password para confirmar la accion</p>
                    {!! form($form) !!}
                </div>
            
            </div>
        </div>
    </div>
    <!-- Modal -->
@stop

@section('adminlte_js')
<script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
<script>
    $(document).on("click", "#cerrar-ejercicio", function (e){
        e.preventDefault();
        var myEmpresa = $(this).data('objetivo');
        var myAccion = $(this).data('accion');
        $('form').attr('action', myAccion);
        $(".modal-body").find('input[name="objeto"]').val(myEmpresa);
        $(".modal-body").find('input[name="accion"]').val(myAccion);
    });
    </script>
@stop