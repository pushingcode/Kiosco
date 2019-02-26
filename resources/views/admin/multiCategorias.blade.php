@extends('adminlte::page')

@section('title', 'Categorias')

@section('content_header')
    <h1>Gestion de Categorias</h1>
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
                    <td>
                        <div class="btn-group" role="group" aria-label="botonera {{ $categoria->codigo }} ">
                            <a class="btn btn-primary" href="{{ url('categoria') }}/{{ $categoria->id }}/edit" role="button"><i class="fas fa-pen-square"></i> Editar</a>
                            <a id="delete-categoria" class="btn btn-danger" role="button" href="#" data-toggle="modal" data-target="#deltCategory" data-objetivo="{{ $categoria->id }}" data-accion="{{ url('categoria/'. $categoria->id ) }}"><i class="fas fa-trash-alt"></i> Eliminar</a>
                        </div>
                    </td>
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
    <!-- Modal -->
    <div class="modal fade" id="deltCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">Verificacion Requerida</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4>Seguro desea eliminar la categoria?</h4>
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
    $(document).on("click", "#delete-categoria", function (e){
        e.preventDefault();
        var myCategoria = $(this).data('objetivo');
        var myAccion    = $(this).data('accion');
        $('form').attr('action', myAccion);
        $(".modal-body").find('input[name="objeto"]').val(myCategoria);
        $(".modal-body").find('input[name="accion"]').val(myAccion);
    });
    </script>
@stop