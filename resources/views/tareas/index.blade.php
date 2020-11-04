@extends('layouts.app')

<style>
    .prue{
        
        border-radius: 10px;
    }

    .ctado:hover{
        opacity: 0.9;
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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Tareas</div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <td>Proyecto</td>
                                    <td>Tarea</td>
                                    <td>Area</td>
                                    <td>Estado</td>
                                    <td>Persona</td>
                                    <td>Asignar</td>
                                    <td>Link</td>
                                    <td>Ver link</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($resultado as $result)
                                <tr>
                                    <td>{{$result->proyecto}}</td>
                                    <td>{{$result->nombre_tarea}}</td>
                                    <td>{{$result->nombre_area}}</td>
                                    @if($result->nombre_estado == "programado")
                                    <td class="ctado" data-toggle="modal" data-target="#ventanaModel{{$result->id}}" style="background-color: #EC7063; border-radius:5px; color: white; text-align: center">{{$result->nombre_estado}}</td>
                                    @elseif($result->nombre_estado == "proceso")
                                    <td class="ctado" data-toggle="modal" data-target="#ventanaModel{{$result->id}}" style="background-color: #F5B041; border-radius:5px; color: white; text-align: center">{{$result->nombre_estado}}</td>
                                    @else 
                                    <td class="ctado" data-toggle="modal" data-target="#ventanaModel{{$result->id}}" style="background-color:#58D68D; border-radius:5px; color: white; text-align: center">{{$result->nombre_estado}}</td>
                                    @endif
                                    <td>{{$result->name}}</td>
                                        @can('actualizar-tareas')
                                        <td><a class="btn btn-primary prue" data-toggle="modal" data-target="#ventana{{$result->id,$result->nombre_tarea}}" href=""><i class="far fa-edit"></i></a>
                                            <!-- Modal -->
                                            <div class="modal fade" id="ventana{{$result->id,$result->nombre_tarea}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Asignar tarea</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        
                                                        <form action="{{route('tareas.update', $result->proyecto_id)}}" method="post">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="text" hidden name="tareaid" value="{{$result->id}}">
                                                        
                                                        <div class="form-group">
                                                            <label for="name">Usuarios</label>
                                                            <select class="form-control" name="tipo" id="">
                                                                @foreach ($usuario as $us)
                                                                <option value="{{$us->id}}">
                                                                    {{$us->name}}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                            <button type="submit" class="btn btn-success">Asignar</button>
                                                            </div>

                                                    </form>
                                                    </div>
                                                    
                                                </div>
                                                </div>
                                            </div>
                                        </td>
                                        @endcan
                            
                                        <td><a class="btn btn-success prue" data-toggle="modal" data-target="#ventanaLink{{$result->id}}" href=""><i class="fas fa-upload"></i></a>
                                            <!-- Modal -->
                                            <div class="modal fade" id="ventanaLink{{$result->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Linkear</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        
                                                        <form action="" method="post">
                                                        @csrf
                                                        @method('PUT')
                                                       
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                            <button type="submit" class="btn btn-success">Añadir</button>
                                                            </div>
                                                    </form>
                                                    </div>   
                                                </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td><a name="" id="" class="btn btn-warning prue" href="" role="button"><i class="far fa-file-word"></i></a></td>

                                        @can('actualizar-estado')
                                        <td>
                                            <!-- Modal -->
                                            <div class="modal fade" id="ventanaModel{{$result->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Cambiar estados</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        
                                                        <form action="{{route('estados.update', $result->proyecto_id)}}" method="post">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="text" hidden name="tarea_id" value="{{$result->id}}">
                                                        <input type="" hidden name="nameEs" value="">

                                                        <div class="form-group">
                                                            <label for="name">Estados</label>
                                                            <select class="form-control" name="est" id="">
                                                                @foreach ($estados as $es)
                                                                <option value="{{$es->id}}">
                                                                    <span id="nameS">{{$es->nombre_estado}}</span>
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                            <button type="submit" class="btn btn-success">Cambiar</button>
                                                            </div>

                                                    </form>
                                                    </div>
                                                    
                                                </div>
                                                </div>
                                            </div>
                                        </td>
                                        @endcan      
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

@section('scrip')

@endsection

