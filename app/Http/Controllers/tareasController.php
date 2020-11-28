<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
    //funcional
    public function show($id)
    {
        //traer usuarios mientras que su estado se 1
        $usuario = User::where('estado',1)->get();
        //traer todos los estados
        $estados = Estado::all();
        //si el usuario autenticado es ariel traer todas las tareas
        if(auth()->user()->name == "Ariel"){
        //procedimiento para traer tareas del proyecto
        $resultado = DB::select('call tareas_por_proyecto3(?)', array($id));  
        return view('tareas.index', compact('resultado','usuario','estados'));
        }else{
        //procedimiento para traer tareas por proyecto y usuario
        $resultado = DB::select('call tareas_por_proyecto(?,?)', array($id,auth()->user()->id));  
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

    //asignar tareas a los usuarios recibimos datos del formulario y el id del proyecto
    public function update(Request $request, $id)
    {
        //id recibido de la tarea
        $id_tarea = $request->tareaid;
        //recibimos el id del usuario
        $id_usu = $request->tipo;

        //convertimos la llegada en string
        is_int($id_usu);
        is_int($id_tarea);
        is_int($id);

        //llamamos al procedimiento asignar tarea y le pasamos el id del proyecto
        //el id del usuario y el id de la tarea
        $resultad = DB::insert('call asignar_tarea(?,?,?)', array($id_usu,$id,$id_tarea));
        
        //registrar acción dentro del log
        if(isset($resultad)){
            $estado = 'Asignó una nueva tarea';
            $nombre_usu = auth()->user()->name;
            $registro_log = DB::insert('call insertar_log(?,?)', array($nombre_usu,$estado));
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
