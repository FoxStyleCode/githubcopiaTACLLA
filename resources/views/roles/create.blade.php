@extends('layouts.app')


@section('contenido')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2>Nuevo role</h2>
                    </div>
                    <div class="card-body">
                        <form action="{{url('roles')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="name">Nombre del role</label>
                                <input type="text" name="namerole" id="name" required class="form-control">
                            </div>
                                <div class="form-group">
                                    <label for="name">Selecciona los permisos para el rol</label>
                                    <select class="form-control" name="permisos[]" id="" multiple>
                                        @foreach ($permisos as $key => $value)
                                        <option value="{{$value}}">
                                            {{$value}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            <div class="justify-content-end">
                                <input class="btn btn-success" type="submit" name="" id="" value="Enviar">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection