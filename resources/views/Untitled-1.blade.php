{{-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>  --}}
    
<script src="{{ asset('js/jquery-3.5.1.min.js') }}" defer></script>


<!--scripts-->
{{-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
 {{-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script> --}}
<script src="{{asset('js/javascript.js') }}"></script>
 @yield('scrip')
 @yield('js') 















 ----------------------------------------------

 @section('js')
 
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.22/b-1.6.5/datatables.min.js"></script>

<script src="{{asset('js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('js/buttons.flash.min')}}"></script>
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


{{-- 
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="{{asset('js/dataTables.bootstrap4.min.js') }}"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="{{asset('js/jquery.dataTables.min.js') }}"></script>

<script src="{{asset('js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('js/buttons.flash.min')}}"></script>
<script src="{{asset('js/jszip.min.js')}}"></script>
<script src="{{asset('js/pdfmake.min.js')}}"></script>
<script src="{{asset('js/vfs_fonts.js')}}"></script>
<script src="{{asset('js/buttons.html5.min.js')}}"></script>
<script src="{{asset('js/buttons.print.min.js')}}"></script>

<script>


   var tabla = $('#mitabla').DataTable({
        
   }); --}}
    
{{-- </script> --}}

@endsection




------------------------------------------------

@section('css')
    <link rel="stylesheet" href="{{asset("css/stilosprinci.css")}}">
    <link rel="stylesheet" href="{{asset("plugins/datatables/datatables.min.css")}}">
    {{-- <link rel="stylesheet" href="{{asset("css/stilosprinci.css")}}"> --}}
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.22/b-1.6.5/datatables.min.css"/> --}}

@endsection
