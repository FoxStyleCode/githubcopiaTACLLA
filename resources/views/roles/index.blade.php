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
                    <div class="card-header">Roles de usuario</div>
                    <div class="card-body">

                        @can('crear-role')
                            <div class="row justify-content-end pb-4">
                                <a href="{{url('roles/create')}}" class="btn btn-success">Nuevo role</a>
                            </div>
                        @endcan
                        <table class="table">
                            <thead>
                                <tr>
                                    <td>nombre</td>
                                    <td>nombre de la guardia</td>
                                    <td>acciones</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                <tr>
                                    <td>{{$role->name}}</td>
                                    <td>{{$role->guard_name}}</td>
                                    <td>
                                        @can('actualizar-role')
                                        <a href="{{'/roles/'.$role->id.'/edit'}}" class="btn btn-primary">Editar</a>
                                        @endcan
                                        @can('eliminar-role')
                                        <form action="{{route('roles.destroy', $role->id)}}" method="post" style="display: inline-block">
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