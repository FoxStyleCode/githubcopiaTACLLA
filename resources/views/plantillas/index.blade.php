@extends('layouts.app')
@section('css')
<style>
    .accordion {
      background-color: #eee;
      color: #444;
      cursor: pointer;
      padding: 18px;
      width: 100%;
      border: none;
      text-align: left;
      outline: none;
      font-size: 15px;
      transition: 0.4s;
    }
    
    .active, .accordion:hover {
      background-color: #ccc; 
    }
    
    .panel {
      padding: 0 18px;
      display: none;
      background-color: white;
      overflow: hidden;
    }
    </style>
@endsection
    
@section('content')
<br>
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
            <div class="card-header">Nueva plantilla</div>
            <div class="card-body">
                <div class="d-flex flex-row-reverse bd-highlight">
                <div class="row justify-content-end ml-1 p-2  bd-highlight">
                    <a class="btn btn-success prue" data-toggle="modal" data-target="#ventanaModalAdd" href="">Añadir</a>
                </div>
                </div>
                <h2>Area de plantillas</h2>
                <button class="accordion" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                Mostrar todas las plantillas
                </button>         
                <div class="collapse" id="collapseExample">
                        <br>
                        <div class="row">
                            @foreach ($resultado as $resul)
                            <div class="col-4">
                                <div class="card">
                                    <img title="titulo-plantilla" alt="Cotización" class="card-img-top w-60" src="/imagenes/{{$resul->dir}}" alt=""/>
                                    <div class="card-body">
                                        <h5 class="card-title">{{$resul->nombre_plantilla}}</h5>
                                        <a target="_blank" href="{{$resul->link}}">{{$resul->nombre_plantilla}}</a>
                                        <form action="{{route('plantillas.destroy', $resul->id)}}" method="post" style="display: inline-block">
                                            @method('DELETE')
                                            @csrf
                                            <input class="btn btn-danger" type="submit" name="" id="" value="Quitar">
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach  
                        </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="ventanaModalAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Nueva Plantilla</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{url('plantillas')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="exampleFormControlFile1">Imagen identificativa</label>
                                <input type="file" name="file" class="form-control-file" id="exampleFormControlFile1">
                              </div>
                            <div class="form-group">
                              <label for="">Nombre de la plantilla</label>
                              <input type="text"
                                class="form-control" name="namep" id="" aria-describedby="helpId" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="">Enlace de la plantilla</label>
                                <input type="text"
                                  class="form-control" name="enlacep" id="" aria-describedby="helpId" placeholder="">
                              </div>
                            
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-success">Agregar</button>
                                </div>
                        </form>
                        </div>     
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
