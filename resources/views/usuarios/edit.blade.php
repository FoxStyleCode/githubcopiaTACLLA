@extends('layouts.app')



@section('contenido')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2>editar usuario</h2>
                    </div>
                    <div class="card-body">
                        <form action="{{route('usuarios.update', $usuario->id)}}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">Nombre</label>
                                <input type="text" name="name" id="name" required class="form-control" value="{{$usuario->name}}">
                            </div>
                            <div class="form-group">
                                <label for="email">Correo</label>
                                <input type="text" name="email" id="" required class="form-control" value="{{$usuario->email}}">
                            </div>
                            <div class="form-group">
                                <label for="password">Contraseña</label>
                            <input type="text" name="password" id="" class="form-control" value="">
                            </div>
                            <div class="form-group">
                                <label for="name">Role</label>
                                <select class="form-control" name="role" id="">
                                    @foreach ($roles as $key => $value)
                                    @if($usuario->hasRole($value))
                                    <option value="{{$value}}" selected>{{$value}}</option>
                                    @else
                                    <option value="{{$value}}">{{$value}}</option>
                                    @endif
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