@extends('adminlte::page')

@section('title', 'Ejercicios Economicos')

@section('content_header')
    <h1>Lista de Empaques y Unidades</h1>
@stop

@section('content')

@include('flash')

<div class="row">
    <div class="col-sm-8">
    
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Gestion de unidades y empaques</h3>
            </div>
            <div class="panel-body">
                <!-- Collapsible -->
                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseForm" aria-expanded="false" aria-controls="collapseForm">
                {{ $collapsibleData['boton']}}
                </button>
                <hr>
                <div class="collapse" id="collapseForm">
                    <div class="well">
                        @if($form == false)
                        @else
                            {!! form($form) !!}
                        @endif
                    </div>
                </div>
                <!-- EndCollapsible -->
            @if(!$unidades->isEmpty())
            
            <table class="table">
                <thead>
                    <tr>
                        <th>Descripcion</th>
                        <th>Unidad</th>
                        <th>Nivel1</th>
                        <th>Nivel2</th>
                        <th>Divisible</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($unidades as $unidad)
                    <tr>
                        <td>{{ $unidad->descripcionU }}</td>
                        <td>{{ $unidad->unidad }}</td>
                        <td>{{ $unidad->unidadesL1 }}</td>
                        <td>{{ $unidad->unidadesL2 }}</td>
                        <td>{{ $unidad->divisible }}</td>
                        <td>
                        <div class="btn-group" role="group" aria-label="botonera {{ $unidad->codigo }} ">
                            <a class="btn btn-primary btn-xs" href="{{ url('unidad') }}/{{ $unidad->id }}/edit" role="button"><i class="fas fa-pen-square"></i> Editar</a>
                            <a id="delete-unidad" class="btn btn-danger btn-xs" role="button" href="#" data-toggle="modal" data-target="#deltUnity" data-objetivo="{{ $unidad->id }}" data-accion="{{ url('unidad/'. $unidad->id ) }}"><i class="fas fa-trash-alt"></i> Eliminar</a>
                        </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $unidades->links() }}
        @else 
            
        @endif
            
                </div>
            </div>
        </div>
        
        <div class="col-sm-4">
            <h3>Dato importante</h3>
            @isset($decript)
                <p>{{ $decript }}</p>
            @endisset
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="deltUnity" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">Verificacion Requerida</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4>Esta por eliminar una unidad de empaque o peso!</h4>
                    <p>Ingrese su Password para confirmar la accion</p>
                    {!! form($confirm) !!}
                </div>
            
            </div>
        </div>
    </div>
    <!-- Modal -->
@stop

@section('adminlte_js')
<script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
<script>
    $(document).on("click", "#delete-unidad", function (e){
        e.preventDefault();
        var myObjetivo = $(this).data('objetivo');
        var myAccion = $(this).data('accion');
        $('form').attr('action', myAccion);
        $(".modal-body").find('input[name="objeto"]').val(myObjetivo);
        $(".modal-body").find('input[name="accion"]').val(myAccion);
    });
    </script>
    <script>
    $('#collapseForm').collapse({
        toggle: {{ $collapsibleData['modo'] }}
        });
    </script>
@stop