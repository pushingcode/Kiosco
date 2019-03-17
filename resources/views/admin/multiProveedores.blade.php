@extends('adminlte::page')

@section('title', 'proveedores')

@section('content_header')
    <h1>Gestion de Proveedores</h1>
@stop

@section('content')

@if($errors->any())
<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Advertencia!</strong> {{$errors->first()}}.
</div>
@endif
    
    <div class="row">
        <div class="col-sm-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Gestion de proveedors</h3>
            </div>
            <div class="panel-body">
            <!-- Collapsible -->
            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseForm" aria-expanded="false" aria-controls="collapseForm">
            {{ $collapsibleData['boton'] }}
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
        @if($proveedores)
            <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Empresa</th>
                    <th>CUIT</th>
                    <th>Telefono</th>
                    <th>Email</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($proveedores as $proveedor)
                <tr>
                    <td>{{ $proveedor->id }}</td>
                    <td>{{ $proveedor->empresa }}</td>
                    <td>{{ $proveedor->cuit }}</td>
                    <td>{{ $proveedor->telefono }}</td>
                    <td>{{ $proveedor->email }}</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="botonera {{ $proveedor->id }} ">
                            <a class="btn btn-primary" href="{{ url('proveedor') }}/{{ $proveedor->id }}/edit" role="button"><i class="fas fa-pen-square"></i> Editar</a>
                            <a id="delete-proveedor" class="btn btn-danger" role="button" href="#" data-toggle="modal" data-target="#deltProduct" data-objetivo="{{ $proveedor->id }}" data-accion="{{ url('proveedor/'. $proveedor->id ) }}"><i class="fas fa-trash-alt"></i> Eliminar</a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
            </table>
            {{ $proveedores->links() }}
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
                    <h4>Seguro desea eliminar el proveedor?</h4>
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
    $(document).on("click", "#delete-proveedor", function (e){
        e.preventDefault();
        var myproveedor = $(this).data('objetivo');
        var myAccion    = $(this).data('accion');
        $('form').attr('action', myAccion);
        $(".modal-body").find('input[name="objeto"]').val(myproveedor);
        $(".modal-body").find('input[name="accion"]').val(myAccion);
    });
    </script>
<script>
    var collap = @json($collapsibleData);
    console.log(collap.modo);
    $('#collapseForm').collapse({
        toggle: collap.modo
    });
</script>
@stop