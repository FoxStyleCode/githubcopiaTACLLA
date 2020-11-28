<?php

namespace App\Http\Controllers;

use App\Plantilla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class plantillasControlador extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //listar todas las plantillas en la vista
        $resultado = DB::select('call traer_plantillas()');
        return view('plantillas.index', compact('resultado'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validar los campos de la plantilla a guardar
        $request->validate([
            'namep' => 'required',
            'enlacep' => 'required',
            'file' => 'required|max:3000',
        ]);
        
        //crear una transacción para evitar guardar datos sin dependencia
        DB::transaction(function() use($request){
        $name_p = $request->namep;
        $enlace_p = $request->enlacep;
        
        //si recibimos un archivo obtener el nombre del archivo y movelo a la carpeta imagenes
        if($archivo=$request->file('file')){
            $nombre = $archivo->getClientOriginalName();
            $archivo->move('imagenes',$nombre); 
        }

        //insertar la información de la plantilla
        $resultado = DB::insert('call insertar_plantilla(?,?,?)', array($nombre, $name_p, $enlace_p)); 
        
        //registrar acción en el log
        if(isset($resultado)){

            $estado = 'Añadió una nueva plantilla llamada' . " " . $name_p;
            $nombre_usu = auth()->user()->name;
            $log = DB::insert('call insertar_log(?,?)', array(
            $nombre_usu,
            $estado
            ));
            return back()->with('success', 'plantilla añadida correctamente');
        }else{
            return back()->with('danger', 'no se añadió la plantilla');
        }
    });
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //buscar la plantilla a eliminar
        $plantilla = Plantilla::FindOrFail($id);
        //llamar al procedimiento que elimina la plantilla
        $resultado = DB::insert('call eliminar_plantilla(?)', array($id)); 

        //registrar acción en el log
        if(isset($resultado)){
            $estado = 'Quitó una plantilla llamada' . " " . $plantilla->nombre_plantilla;
            $nombre_usu = auth()->user()->name;
            $log = DB::insert('call insertar_log(?,?)', array(
            $nombre_usu,
            $estado
            ));
            return back()->with('success', 'plantilla removida correctamente');
        }else{
            return back()->with('danger', 'no se pudo remover la plantilla');
        }
    }
}
