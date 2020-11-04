@extends('layouts.app')


@section('content')
<br>
<br>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2>nuevo usuario</h2>
                    </div>
                    <div class="card-body">
                        <form action="{{url('usuarios')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="name">Nombre</label>
                                <input type="text" name="name" id="name" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="email">Correo</label>
                                <input type="text" name="email" id="" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password">Contraseña</label>
                                <input type="password" name="password" id="" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="name">Area</label>
                                <select class="form-control" name="area" id="">
                                    @foreach ($areas as $area)
                                    <option value="{{$area->id}}">
                                        {{$area->nombre_area}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="name">Role</label>
                                <select class="form-control" name="role" id="">
                                    @foreach ($roles as $key => $value)
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