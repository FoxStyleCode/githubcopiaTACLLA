<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class agregarTareasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            //validamos que la tarea traiga un nombre y un área
            $request->validate([
                'nombretarea' => 'required',
                'area' => 'required',
            ]);
    
            //guardamos en variables
            $nombre_t = $request->nombretarea;
            $area = $request->area;

            //llamar al procedimiento para guardar la tarea
            $insercion = DB::insert('call insertar_tarea_area(?,?)', array($nombre_t,$area));
    
            //insertar en el log
            if($insercion){
                $estado = 'Añadió una nueva tarea llamada' . " " . $nombre_t;
                $nombre_usu = auth()->user()->name;
                $log = DB::insert('call insertar_log(?,?)', array(
                $nombre_usu,
                $estado
                ));
                return back()->with('success', 'Tarea agregada correctamente'); 
            }else{
                return back()->with('danger', 'No se pudo agregar la tarea'); 
            }
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
        //
    }
}
