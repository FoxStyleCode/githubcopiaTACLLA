@extends('layouts.app')

@section('css')

<style>
    .thead-green {
      background-color: rgb(0, 99, 71);
      color: white;
    }
</style>


@endsection

@section('contenido')
    <div class="container">

        @if(session('danger'))
        <div class="alert alert-danger" role="alert">
            {{session('danger')}}
        </div>
        @endif
        @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{session('success')}}
        </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-md-10 text-center">
                <div class="card">
                    <div class="card-header">Todos los enlaces</div>
                    <div class="card-body">  
                        <div class="table-responsive">      
                        <table class="table table-striped">
                            <thead class="thead-green">
                                <tr>
                                    <td>Nombre de la tarea</td>
                                    <td>Enlace</td>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($resultado as $datos)
                               <tr>
                                <td>{{$datos->nombre_tarea}}</td>
                                @if(isset($datos->enlace))
                                <td><a target="_blank" href="{{$datos->enlace}}">Revisar archivo</a></td>
                                @else

                                @endif
                               </tr>
                            @endforeach
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
