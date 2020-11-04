@extends('layouts.app')

<style>
    .prue{
        margin: 2px;
    }
</style>

@section('content')
<br>
<br>
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
            <div class="col-md-16 text-center">
                <div class="card">
                    <div class="card-header">Lista de proyectos</div>
                    <div class="card-body">

                        <div class="d-flex flex-row-reverse bd-highlight">
                            <div class="row justify-content-end ml-1 p-2  bd-highlight">
                                <a class="btn btn-success prue" data-toggle="modal" data-target="#ventanaModelTipo" href="">Configurar tipo</a>
                            </div>
                            <div class="row justify-content-end ml-1 p-2 bd-highlight">
                                <a class="btn btn-success prue" data-toggle="modal" data-target="#ventanaTareas" href="">Configurar tarea</a>
                            </div>
                            @can('crear-proyecto')
                            <div class="row justify-content-end ml-1 p-2 bd-highlight">
                                <a href="{{url('proyectos/create')}}" class="btn btn-primary prue">Nuevo proyecto</a>
                            </div>
                             @endcan
                          </div>
                          <br>
                                <!-- Modal -->
                                <div class="modal fade" id="ventanaModelTipo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Nuevo tipo de proyecto</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <div class="modal-body">
                                            <guardar-tarea :task="{{$tipos}}"></guardar-tarea> 
                                        </div>     
                                    </div>
                                    </div>
                                </div>

                                <!-- Modal -->
                                <div class="modal fade" id="ventanaTareas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Nueva tarea</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <div class="modal-body">
                                            
                                            <form action="{{url('nuevTarea')}}" method="post">
                                            @csrf
                
                                            <div class="form-group">
                                              <label for="">Nombre de la tarea</label>
                                              <input type="text"
                                                class="form-control" name="nombreta" id="" aria-describedby="helpId" placeholder="">
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="name">Area</label>
                                                <select class="form-control" name="area" id="">
                                                    @foreach($areas as $value)
                                                    <option value="{{$value->id}}">
                                                        {{$value->nombre_area}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                <button type="submit" class="btn btn-success">Crear</button>
                                                </div>
                                        </form>
                                        </div>     
                                    </div>
                                    </div>
                                </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <td>Jugador</td>
                                    <td>Numero proyecto</td>
                                    <td>Fecha</td>
                                    <td>Cliente</td>
                                    <td>Nombre proyecto</td>
                                    <td>Predio</td>
                                    <td>Municipio</td>
                                    <td>Tipo de proyecto</td>
                                    <td>Acciones</td>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $datos)
                               <tr>
                                <td>{{$datos->player}}</td>
                                <td>{{$datos->pryct}}</td>
                                <td>{{$datos->fecha}}</td>
                                <td>{{$datos->cliente}}</td>
                                <td>{{$datos->proyecto}}</td>
                                <td>{{$datos->predio}}</td>
                                <td>{{$datos->municipio}}</td>
                                <td>{{$datos->nombre}}</td>
                                <td class="d-flex">
                                    <a class="btn btn-primary prue" href="{{url('/proyectos/'.$datos->id. '/edit')}}"><i class="far fa-edit"></i></a>
                                    <a name="" id="" class="btn btn-warning prue" href="{{route('tareas.show', $datos->id)}}" role="button"><i class="far fa-eye"></i></a>
                                    <a name="" id="" class="btn btn-danger prue" href="#" role="button"><i class="far fa-window-close"></i></a>
                                    <a name="" id="" class="btn btn-info prue" href="#" role="button"><i class="far fa-file-alt"></i></a>
                                </td>
                               </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')


@endsection
