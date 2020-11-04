@extends('layouts.app')

@section('plugins.Sweetalert2', true)

@section('content')

<p>Bienvenido {{Auth::user()->name}}</p>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        Swal.fire(
        'Estas logueado!',
        'Has click en el botón de abajo!',
        'Aceptar'
        )
    </script>
@stop
