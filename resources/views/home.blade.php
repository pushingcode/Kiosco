@extends('adminlte::page')

@section('title', 'KiozcoLTs')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')

@if($errors->any())
<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Advertencia!</strong> {{$errors->first()}}.
</div>
@endif

<h3>Ultimas Actividades</h3>

<table class="table">
<thead>
<tr>
  <th scope="col">Fecha</th>
  <th scope="col">Accion</th>
  <th scope="col">Tipo</th>
  <th scope="col">Accion</th>
  <th scope="col">Operador</th>
</tr>
</thead>
<tbody>
    @forelse($activity as $actividad)

    <tr class="bg-{{ $actividad->log_name }}">
    <th scope="row">
        {{ \Carbon\Carbon::parse($actividad->created_at)->format('d/m/Y') }}
    </th>
    <td>
        {{ $actividad->description }}
    </td>
    <td>
        {{ $actividad->subject_type }}
    </td>
    <td>
        @php
            $data = json_decode($actividad->properties, true);
            foreach($data as $key => $value){
                echo $key.": ".$value."<br>";
            }
        @endphp
    </td>
    <td>
        {{ $actividad->name }}
    </td>
    </tr>

    @empty

    <tr>
    <th scope="row">N/A</th>
    <td>N/A</td>
    <td>N/A</td>
    <td>N/A</td>
    <td>N/A</td>
    </tr>

    @endforelse
</tbody>
</table>
@stop