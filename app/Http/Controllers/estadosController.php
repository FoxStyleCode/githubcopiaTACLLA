<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Estado;
use App\Notifications\notificarUsuarios;
use App\User;
use App\Detalle;
use Illuminate\Support\Facades\Auth;

class estadosController extends Controller
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
        $resultado = \DB::select('call tareas_por_proyecto2(?)', array($id));  
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
        $id_tarea = $request->tarea_id;
        $id_esta = $request->est;

        is_int($id_esta);
        is_int($id_tarea);
        is_int($id);

        $resultad = \DB::select('call cambiar_estado(?,?,?)', array($id_esta,$id,$id_tarea));

        User::all()->except(auth()->user()->id)
        ->each(function(User $user){
            $user->notify(new notificarUsuarios());
        });

        if($id_esta == 1){
            $estado = 'Actualizó un estado a programado';
        }elseif($id_esta == 2){
            $estado = 'Actualizó un estado a en proceso';
        }else{
            $estado = 'Actualizó un estado a finalizado';
        }
        
        $nombre_usu = auth()->user()->name;
        $registro_log = \DB::insert('call insertar_log(?,?)', array($nombre_usu,$estado)); 
        
        if(isset($resultad)){
            return back()->with('success', 'se ha cambiado el estado de la tarea');
        }else{
            return back()->with('danger', 'no se pudo cambiar el estado de la tarea');
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
