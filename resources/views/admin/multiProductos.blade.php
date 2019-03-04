@extends('adminlte::page')

@section('title', 'Productos')

@section('content_header')
    <h1>Gestion de Productos</h1>
@stop

@section('content')
    
    <div class="row">
        <div class="col-sm-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Gestion de unidades y empaques</h3>
            </div>
            <div class="panel-body">
        @if($form == false)
        @else
            {!! form($form) !!}
        @endif
        <hr>
        @if($productos)
            <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Descripcion</th>
                    <th>marca</th>
                    <th>Codigo</th>
                    <th>SKU</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productos as $producto)
                <tr>
                    <td>{{ $producto->id }}</td>
                    <td>{{ $producto->descripcionP }}</td>
                    <td>{{ $producto->marca }}</td>
                    <td>{{ $producto->codigoP }}</td>
                    <td>{{ $producto->sku }}</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="botonera {{ $producto->codigo }} ">
                            <a class="btn btn-primary" href="{{ url('producto') }}/{{ $producto->id }}/edit" role="button"><i class="fas fa-pen-square"></i> Editar</a>
                            <a id="delete-producto" class="btn btn-danger" role="button" href="#" data-toggle="modal" data-target="#deltProduct" data-objetivo="{{ $producto->id }}" data-accion="{{ url('producto/'. $producto->id ) }}"><i class="fas fa-trash-alt"></i> Eliminar</a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
            </table>
            {{ $productos->links() }}
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
    <div class="modal fade" id="deltProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">Verificacion Requerida</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4>Seguro desea eliminar el producto?</h4>
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
    $(document).on("click", "#delete-producto", function (e){
        e.preventDefault();
        var myproducto = $(this).data('objetivo');
        var myAccion    = $(this).data('accion');
        $('form').attr('action', myAccion);
        $(".modal-body").find('input[name="objeto"]').val(myproducto);
        $(".modal-body").find('input[name="accion"]').val(myAccion);
    });
    </script>
@stop