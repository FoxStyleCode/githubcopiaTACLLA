<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Estado;

class tareasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('tareas.show'); 
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
        $usuario = User::all();
        $estados = Estado::all();
        if(auth()->user()->name == "Ariel"){
        $resultado = \DB::select('call tareas_por_proyecto3(?)', array($id));  
        return view('tareas.index', compact('resultado','usuario','estados'));
        }else{
        $resultado = \DB::select('call tareas_por_proyecto(?,?)', array($id,auth()->user()->id));  
        return view('tareas.index', compact('resultado','usuario', 'estados'));  
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
        $id_tarea = $request->tareaid;
        $id_usu = $request->tipo;

        is_int($id_usu);
        is_int($id_tarea);
        is_int($id);

        $resultad = \DB::select('call asignar_tarea(?,?,?)', array($id_usu,$id,$id_tarea));
        
        if(isset($resultad)){
            $estado = 'Asignó una nueva tarea';
            $nombre_usu = auth()->user()->name;
            $registro_log = \DB::insert('call insertar_log(?,?)', array($nombre_usu,$estado));
            return back()->with('success', 'tarea asignada correctamente');
        }else{
            return back()->with('danger', 'no se pudo asignar la tarea correspondiente');
        }
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
