@extends('adminlte::page')

@section('title', 'Configuracion General')

@section('content_header')
    <h1>Datos de Configuracion</h1>
@stop

@section('content')

    @if($errors->any())
    <h4>{{$errors->first()}}</h4>
    @endif

    @if ($conf === false)
    <p><a href="{{ url('admin/config/create') }}">Crear Configuracion Inicial</a></p>
    @else
    <table class="table">
    <thead>
        <tr>
        <th scope="col">#</th>
        <th scope="col">Empresa</th>
        <th scope="col">CUIT</th>
        <th scope="col">Telefono</th>
        <th scope="col">Ejercicio</th>
        <th scope="col">Opciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($conf as $empresa)
            <tr>
                <th scope="row">
                    {{ $empresa->id }}
                </th>
                <td>
                    {{ $empresa->empresa }}
                </td>
                <td>
                    {{ $empresa->cuit }}
                </td>
                <td>
                    {{ $empresa->telefono }}
                </td>
                <td>
                    <div class="btn-group" role="group">
                        <a role="button" class="btn btn-primary" href="{{ url('admin/config/create') }}">Crear</a>
                        <a role="button" class="btn btn-danger" href="{{ url('admin/config/create') }}">ver</a>
                    </div>
                </td>
                <td>
                    <div class="btn-group" role="group">
                        <a role="button" class="btn btn-primary" href="{{ url('admin/config/edit') }}/{{$empresa->id}}">Editar</a>
                        <a id="delete-empresa" role="button" class="btn btn-danger" href="#" data-toggle="modal" data-target="#deltOrder" data-objetivo="{{$empresa->id}}" data-accion="{{ url('admin/config/destroy') }}/{{$empresa->id}}">Eliminar</a>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
    </table>
    <!-- Modal -->
    <div class="modal fade" id="deltOrder" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">Verificacion Requerida</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4>Seguro desea eliminar la empresa!</h4>
                    <p>Ingrese su Password para confirmar la accion</p>
                    {!! form($form) !!}
                </div>
            
            </div>
        </div>
    </div>
    <!-- Modal -->
    
    @endif
@stop

@section('adminlte_js')
    <script>
    $(document).on("click", "#delete-empresa", function (e){
        e.preventDefault();
        var myEmpresa = $(this).data('objetivo');
        var myAccion = $(this).data('accion');
        $('form').attr('action', myAccion);
        $(".modal-body").find('input[name="objeto"]').val(myEmpresa);
        $(".modal-body").find('input[name="accion"]').val(myAccion);
    });
    </script>
@stop