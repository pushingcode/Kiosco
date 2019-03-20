@extends('adminlte::page')

@section('title', 'Almacenes y Depositos')

@section('content_header')
    <h1>Almacenes Disponibles</h1>
@stop

@section('content')

@include('flash')

    @if($errors->any())
    <h4>{{$errors->first()}}</h4>
    @endif
    <a class="btn btn-primary" href="{{ url('almacen/create') }}" role="button">Nuevo Almacen</a>
    <table class="table">
    <thead>
        <tr>
        <th scope="col">#</th>
        <th scope="col">Almacen</th>
        <th scope="col">Codigo</th>
        <th scope="col">Nota</th>
        <th scope="col">Ubicacion</th>
        <th scope="col">Estado</th>
        <th>Opciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($almacenes as $almacen)
            <tr>
                <th scope="row">
                    {{ $almacen->id }}
                </th>
                <td>
                    {{ $almacen->nombre }}
                </td>
                <td>
                    {{ $almacen->codigo }}
                </td>
                <td>
                    {{ $almacen->notas }}
                </td>
                <td>
                    {{ $almacen->direccion }}
                </td>
                <td>
                    {{ $almacen->estado }}
                </td>
                <td>
                    @if($almacen->estado === 'activo')
                        <a id="cerrar-almacen" role="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#deltStorage" data-objetivo="{{ $almacen->id }}" data-accion="{{ url('almacen/'. $almacen->id ) }}" href="#">Cerrar</a>
                    @else
                        CERRADO
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
    </table>
    <a class="btn btn-primary" href="{{ url('almacen/create') }}" role="button">Nuevo Almacen</a>
    <!-- Modal -->
    <div class="modal fade" id="deltStorage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">Verificacion Requerida</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4>Esta por cerrar este Almacen!</h4>
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
        $(document).on("click", "#cerrar-almacen", function (e){
            e.preventDefault();
            var myEmpresa = $(this).data('objetivo');
            var myAccion = $(this).data('accion');
            $('form').attr('action', myAccion);
            $(".modal-body").find('input[name="objeto"]').val(myEmpresa);
            $(".modal-body").find('input[name="accion"]').val(myAccion);
        });
    </script>
@stop