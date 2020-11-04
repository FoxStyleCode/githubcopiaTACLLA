@extends('layouts.app')


@section('content')
<br>
<br>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2>editar role</h2>
                    </div>
                    <div class="card-body">
                        <form action="{{route('roles.update', $roles->id)}}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">Nombre role</label>
                                <input type="text" name="namerole" id="name" required class="form-control" value="{{$roles->name}}">
                            </div>


                            <div class="form-group">
                                <ul class="list-unstyled">
                                 @foreach($permissions as $permission)
                                  <div class="form-check">
                                 <label class="form-check-label" for="permissions[{{ $permission->id }}]">
                                    <!--
                                    En la vista recibimos 2 arrays : "permissions" que contiene TODOS los PERMISOS y "assignedPermisions" que contiene los PERMISOS asignados a cada ROLE
                                    Vamos recorriendo el ARRAY de TODOS los PERMISOS y generando los INPUT CHECKBOX
                                    Si el ID del PERMISO $permission->id se encuenta el array de assignedPermissions ponemos el texto "checked" y si no ""
                                    -->
                                    <input type="checkbox" value="{{ $permission->id }}"
                                      name="permissions[]" id="permissions[{{ $permission->id }}]"
                                      class="form-check-input"
                                      @if(isset($assignedPermissions))
                                      {{in_array($permission->id,$assignedPermissions) ? 'checked':''}}@endif
                                      >{{ $permission->name }}
                                    <em>(</em><em style="color:">{{ $permission->description ? : 'Sin descripción' }}</em><em>)</em>
                                   </label>
                                  </div>
                                 @endforeach
                                </ul>
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