<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class tipoController extends Controller
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
        $tipo = \App\tipo_de_proyecto::create(['nombre'=> $request->nombretipo]);
        //agregar area y tipo a las tareas
      
       

        foreach($request->value as $tarea){
            $t = \App\Tarea::create([
                'nombre_tarea' => $tarea['nombre_tarea'], 
                'tipo_de_proyecto_id' => $tipo->id, 
                'area_id'=> $tarea['area_id'],
            ]);
        }

        return ;

        /*$result = \DB::select('CAll insertar_tipo(?)', array($request->nombretipo));
        $array_tipo = $request->tareastipo;

        foreach($array_tipo as $t){
            $result = \DB::select('CAll traer_tipo()');
            $resultado = end($result); //resultado->id = id del registro del ultimo proyecto
            $insercion = \DB::select('call insertar_tarea(?,?)', array(
            $t,$resultado->id));
        }*/
        
        //codigo de log y redireccionamiento

        if(isset($insercion)){
            $estado = ("Añadido nuevo tipo de proyecto llamado: ".$request->nombretipo);
            $nombre_usu = auth()->user()->name;
            $registro_log = \DB::select('call insertar_log(?,?)', array($nombre_usu, $estado));
            return back()->with('success', 'Tipo de proyecto configurado correctamente');
        }else{
            return back()->with('danger', 'No se pudo configurar el tipo de proyecto nuevo');
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
