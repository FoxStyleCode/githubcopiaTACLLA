<?php

namespace App\Http\Controllers;

use App\Proyecto;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class cerradosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //llamar al procedimiento con todos los proyectos cerrados
        $data = DB::select('call listar_proyectos_cerrados()');
        return view('cerrados.index', compact('data'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //buscar el proyecto con el id recibido
        $pr = Proyecto::FindOrFail($id);
        //actualizar el proyecto con el id recibido
        $proyecto = DB::insert('call actualizar_estado_proyecto(?)', array($id));
        //registrar acción en el log
        if(isset($proyecto)){
            $estado = 'Cerró el proyecto' . " " . $pr->proyecto;
            $nombre_usu = auth()->user()->name;
            $log = DB::insert('call insertar_log(?,?)', array(
            $nombre_usu,
            $estado
            ));
            return redirect('/proyectos')->with('eliminar', 'eliminado');
        }else{
            return redirect('/proyectos')->with('danger', 'No se pudo cerrar el proyecto');
        }
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
        //buscar el proyecto a actualizar
        $pr = Proyecto::FindOrFail($id);
        //llamar al procedimiento para actualizar el estado
        $proyecto = DB::insert('call actualizar_estado_proyecto(?)', array($id));
        //registrar acción en el log
        if(isset($proyecto)){
            $estado = 'Cerró el proyecto' . " " . $pr->proyecto;
            $nombre_usu = auth()->user()->name;
            $log = DB::insert('call insertar_log(?,?)', array(
            $nombre_usu,
            $estado
            ));
            return redirect('/proyectos')->with('success', 'El proyecto ha sido cerrado correctamente');
        }else{
            return redirect('/proyectos')->with('danger', 'No se pudo cerrar el proyecto');
        }   
    }
}
