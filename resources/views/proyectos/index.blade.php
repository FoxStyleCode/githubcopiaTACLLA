@extends('layouts.app')


@section('css')
<style>
    .prue{
        margin: 1px;
    }


</style>
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="{{asset('plugins/sweetalert2/dist/sweetalert2.min.css')}}">
@endsection

@section('contenido')
    <div class="container">

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

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
                            @can('crear-tipo-proyecto')
                            <div class="row justify-content-end ml-1 p-2  bd-highlight">
                                <a class="btn btn-success prue" data-toggle="modal" data-target="#ventanaModelTipo" href="">Configurar tipo</a>
                            </div>
                            @endcan
                            @can('crear-tareas')
                            <div class="row justify-content-end ml-1 p-2 bd-highlight">
                                <a class="btn btn-success prue" data-toggle="modal" data-target="#ventanaTareas" href="">Configurar tarea</a>
                            </div>
                            @endcan
                            @can('crear-proyecto')
                            <div class="row justify-content-end ml-1 p-2 bd-highlight">
                                <a href="{{url('proyectos/create')}}" class="btn btn-primary prue">Nuevo proyecto</a>
                            </div>
                            @endcan
                          </div>
                          <br>

                        @section('content')
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
                                    <guardar-tarea2 :task="{{$tipos}}"/>
                                </div>     
                            </div>
                            </div>
                        </div>
                        @endsection
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
                                        class="form-control" name="nombretarea" id="" aria-describedby="helpId" placeholder="">
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

                        <table class="table" id="mitablap">
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
                                <td>{{$datos->name}}</td>
                                <td>{{$datos->pryct}}</td>
                                <td>{{$datos->fecha}}</td>
                                <td>{{$datos->cliente}}</td>
                                <td>{{$datos->proyecto}}</td>
                                <td>{{$datos->predio}}</td>
                                <td>{{$datos->municipio}}</td>
                                <td>{{$datos->nombre}}</td>
                                <td class="d-flex">
                                    @can('editar-proyecto')
                                    <a class="btn btn-primary prue" href="{{url('/proyectos/'.$datos->id. '/edit')}}"><i class="far fa-edit"></i></a>
                                    @endcan
                                    @can('ver-tareas')
                                    <a name="" id="" class="btn btn-warning prue" href="{{route('tareas.show', $datos->id)}}" role="button"><i class="far fa-eye"></i></a>
                                    @endcan
                                    @can('eliminar-proyecto')
                                    <form action="{{route('cerrados.destroy', $datos->id)}}" class="formulario-cerrar" method="post">
                                        @method('DELETE')
                                        @csrf

                                        <button type="submit" class="btn btn-danger prue"><i class="far fa-window-close"></i></button>
                                    </form>

                                    {{-- <a name="" id="for-cerr" class="btn btn-danger prue form-eliminar" href="{{route('cerrados.show', $datos->id)}}" role="button"><i class="far fa-window-close"></i></a> --}}
                                    @endcan
                                    {{-- <a name="" hidden id="" class="myLink" href="{{route('cerrados.show', $datos->id)}}" role="button"></a> --}}
                                    <a name="" id="" class="btn btn-info prue" href="{{route('links.show', $datos->id)}}" role="button"><i class="far fa-file-alt"></i></a>
                                </td>
                               </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {{-- {{$data->links()}} --}}

                    </div>
                </div>
            </div>
        </div>
    </div> 
@endsection


@section('scripts')

{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script> --}}

<script src="{{asset('plugins/sweetalert2/dist/sweetalert2.all.min.js')}}"></script>

<script src="{{asset('js/jquery-3.5.1.js')}}"></script>
<script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/dataTables.responsive.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/dataTables.buttons.min.js')}}"></script>

<script type="text/javascript">
    var tabla = $('#mitablap').DataTable({
        responsive: true,
        autoWidth: true,

        "language": {  
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "No hay proyectos cerrados con este nombre",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No records available",
            "infoFiltered": "(filtrando de _MAX_ registros totales)",
            "search": "Buscar",
            "paginate": {
            "previous": "Anterior",
            "next": "Siguiente",
            }
            }
        });
</script>

        @if(session('eliminar')=='eliminado')
        <script>
            Swal.fire(
            'Cerrado!',
            'El proyecto ha sido cerrado correctamente.',
            'success'
            );
        </script>
        @endif

<script>
    $('.formulario-cerrar').submit(function(e){
        e.preventDefault();

            Swal.fire({
            title: '¿Cerrar el proyecto?',
            text: "Estás seguro que deseas cerrar este proyecto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si, Cerrar Proyecto!'
            }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });
</script>


@endsection
