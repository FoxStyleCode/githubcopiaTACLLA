@extends('layouts.app')

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
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Lista de usuarios</div>
                    <div class="card-body">

                        @can('crear-usuario')
                            <div class="row justify-content-end pb-4">
                                <a href="{{url('usuarios/create')}}" class="btn btn-success"><i class="fas fa-user-plus"></i></a>
                            </div>
                        @endcan
                        <table class="table">
                            <thead>
                                <tr>
                                    <td>nombre</td>
                                    <td>correo</td>
                                    <td>role</td>
                                    <td>acciones</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user as $usuario)
                                <tr>
                                    <td>{{$usuario->name}}</td>
                                    <td>{{$usuario->email}}</td>
                                    <td>{{$usuario->roles->implode('name', '')}}</td>
                                    <td>
                                        @can('actualizar-usuario')
                                        <a href="{{url('/usuarios/'.$usuario->id.'/edit')}}" class="btn btn-primary"><i class="fas fa-user-edit"></i></a>
                                        @endcan
                                        @can('eliminar-usuario')
                                        <form action="{{route('usuarios.destroy', $usuario->id)}}" method="post" style="display: inline-block">
                                            @method('DELETE')
                                            @csrf
                                            <input class="btn btn-danger" type="submit" name="" id="" value="Eliminar">
                                        </form>
                                        @endcan
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