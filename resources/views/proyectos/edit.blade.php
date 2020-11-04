@extends('layouts.app')


@section('content')
<br>
<br>
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
                                <label for="name">Jugador</label>
                                <input type="text" name="name" id="name" required class="form-control" autocomplete="off" value="{{$proyectos->player}}">
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