@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="{{asset('plugins/sweetalert2/dist/sweetalert2.min.css')}}">
@endsection

@section('contenido')
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
                                <a href="{{url('roles/create')}}" class="btn btn-success"><i class="fas fa-plus-square"></i></a>
                            </div>
                        @endcan
                        <table class="table" id="mitablarole">
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
                                        <a href="{{'/roles/'.$role->id.'/edit'}}" class="btn btn-primary"><i class="far fa-edit"></i></a>
                                        @endcan
                                        @can('eliminar-role')
                                        <form action="{{route('roles.destroy', $role->id)}}" class="quitar-role" method="post" style="display: inline-block">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-danger"><i class="fas fa-eraser"></i></button>
                                            {{-- <input class="btn btn-danger" type="submit" name="" id="" value="Eliminar"> --}}
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

@section('scripts')

{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script> --}}

<script src="{{asset('plugins/sweetalert2/dist/sweetalert2.all.min.js')}}"></script>

<script src="{{asset('js/jquery-3.5.1.js')}}"></script>
<script src="{{asset('js/jquery.dataTables.min.js')}}"></script>

<script type="text/javascript">
    $('.quitar-role').submit(function(e){
        e.preventDefault();
        Swal.fire({
            title: '¿Eliminar role?',
            text: "¿Estás seguro que deseas eliminar este role?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si, Eliminar!'
            }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });

</script>

<script src="{{asset('js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('js/dataTables.buttons.min.js')}}"></script>

<script>
    var tabla = $('#mitablarole').DataTable({
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
@endsection