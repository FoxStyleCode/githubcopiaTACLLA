@extends('layouts.app')


@section('css')
    <link rel="stylesheet" href="{{asset("css/stilosprinci.css")}}">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css"> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.bootstrap4.min.css">
@endsection

@section('contenido')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Log</div>
                <div class="card-body">
                    <table class="table-primary" id="mitabla" style="width:100%">
                        <thead class="thead-light">
                            <tr>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Usuario</th>
                                <th>Modificación</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($logs as $log)
                        <tr>
                            <td>{{$log->fecha}}</td>
                            <td>{{$log->hora}}</td>
                            <td>{{$log->usuario}}</td>
                            <td>{{$log->modificacion}}</td>
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
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.22/b-1.6.5/datatables.min.js"></script>
<script src="{{asset('js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('js/jszip.min.js')}}"></script>
<script src="{{asset('js/pdfmake.min.js')}}"></script>
<script src="{{asset('js/vfs_fonts.js')}}"></script>
<script src="{{asset('js/buttons.html5.min.js')}}"></script>
<script src="{{asset('js/buttons.print.min.js')}}"></script>
<script>
    var tabla = $('#mitabla').DataTable({
        responsive: true,
        autoWidth: true,
        dom: '<"top"Bf><"top">rt<"bottom"lpi><"clear">',
        
        buttons: [{
        //Botón para Excel
        extend: 'excelHtml5',
        footer: true,
        titleAttr: 'Exportar a excel',
        filename: 'Export_File',
        className: "excel",
        //Aquí es donde generas el botón personalizado
        text: '<button class="btn btn-success prue"><i class="fas fa-file-excel"></i></button>'
        },
        {
        extend: 'pdfHtml5',
        footer: true,
        titleAttr: 'Exportar a PDF',
        filename: 'Reporte_PDF',
        className: "pdf",
        text: '<button class="btn btn-danger prue"><i class="far fa-file-pdf"></i></button>'
        },
        {
        extend: 'csv',
        footer:true,
        titleAttr: 'Exportar a CSV',
        filename: 'Reporte_CSV',
        className: 'csv',
        text: '<button class="btn btn-warning prue"><i class="fas fa-file-csv"></i></button>'
        },
        {
        extend: 'copyHtml5',
        footer: true,
        titleAttr: 'Copiar reporte',
        filename: 'Export_File_copy',
        className: "copy",
        text: '<button class="btn btn-primary prue"><i class="far fa-copy"></i></button>'
        }
        ],

        "language": {  
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "No hay registros - lo sentimos",
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






