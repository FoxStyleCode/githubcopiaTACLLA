@extends('layouts.app')

@section('css')
    {{-- <link rel="stylesheet" href="{{asset("css/stilosprinci.css")}}"> --}}
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css"> --}}
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css"> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
@endsection

@section('contenido')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Proyectos cerrados</div>
                <div class="card-body">
                    <table class="table-success" id="mitabla" style="width:100%">
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
                            <td>{{$datos->player}}</td>
                            <td>{{$datos->pryct}}</td>
                            <td>{{$datos->fecha}}</td>
                            <td>{{$datos->cliente}}</td>
                            <td>{{$datos->proyecto}}</td>
                            <td>{{$datos->predio}}</td>
                            <td>{{$datos->municipio}}</td>
                            <td>{{$datos->nombre}}</td>
                            <td>
                                <div class="row">
                                    <div style="margin-right:2px">
                                        <a name="" id="" class="btn btn-warning" href="{{route('tareas.show', $datos->id)}}" role="button"><i class="far fa-eye"></i></a>
                                    </div>
                                    <div style="margin-left:2px">
                                        <a name="" id="" class="btn btn-info" href="{{route('links.show', $datos->id)}}" role="button"><i class="far fa-file-alt"></i></a>
                                    </div>
                                </div>
                            </td>
                           </tr>
                        @endforeach
                        </tbody>
                        <tfoot>  
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script src="js/jquery-3.5.1.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="{{asset('js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('js/dataTables.buttons.min.js')}}"></script>

<script>
    var tabla = $('#mitabla').DataTable({
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