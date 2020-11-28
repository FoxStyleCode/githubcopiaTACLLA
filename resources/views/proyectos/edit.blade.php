@extends('layouts.app')


@section('contenido')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2>Editar proyecto</h2>
                    </div>
                    <div class="card-body">
                        @foreach($proyecto as $proyectos)
                        <form action="{{route('proyectos.update', $proyectos->id)}}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">Tipo de proyecto</label>
                                <select class="form-control" name="tipo" id="">
                                    @foreach ($data as $datos)
                                    @if($proyectos->tipo_de_proyecto_id==$datos->id)
                                    <option selected value="{{$datos->id}}">
                                        {{$datos->nombre}}
                                    </option>
                                    @else
                                    <option value="{{$datos->id}}">
                                        {{$datos->nombre}}
                                    </option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="num">Numero del proyecto</label>
                                <input type="text" name="num" id="" required class="form-control" autocomplete="off" value="{{$proyectos->pryct}}">
                            </div>
                            <div class="form-group">
                                <label for="fech">Fecha</label>
                                <input type="date" name="fech" id="" required class="form-control" value="{{$proyectos->fecha}}">
                            </div>
                            <div class="form-group">
                                <label for="cli">Cliente</label>
                                <input type="text" name="cli" id="" required class="form-control" autocomplete="off" value="{{$proyectos->cliente}}">
                            </div>
                            <div class="form-group">
                                <label for="nom">Nombre del proyecto</label>
                                <input type="text" name="nom" id="" required class="form-control" autocomplete="off" value="{{$proyectos->proyecto}}">
                            </div>
                            <div class="form-group">
                                <label for="ver">Predio - Vereda</label>
                                <input type="text" name="ver" id="" required class="form-control" autocomplete="off" value="{{$proyectos->predio}}">
                            </div>
                            <div class="form-group">
                                <label for="muni">Municipio</label>
                                <input type="text" name="muni" id="" required class="form-control" autocomplete="off" value="{{$proyectos->municipio}}">
                            </div>
                            <div class="justify-content-end">
                                <input class="btn btn-success" type="submit" name="" id="" value="Enviar">
                            </div>
                        </form>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection