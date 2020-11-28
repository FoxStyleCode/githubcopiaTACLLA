<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Estado;
use App\Notifications\notificarUsuarios;
use App\User;
use App\Detalle;
use App\Proyecto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

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


    //fin funcionamiento
    public function show($id)
    {
        //buscar todos los usuarios usando el modelo
        $usuario = User::all();

        //traer todos los estados
        $estados = Estado::all();

        //si el usuario logueado es ariel entonces
        if(auth()->user()->name == "Ariel"){
        //ejecutar una consulta que traiga todas las tareas por proyecto junto con los usuarios y demás
        $resultado = DB::select('call tareas_por_proyecto2(?)', array($id));
        //conpactar en la vista de tareas index el resultado, los usuario y los estados para actualizar los estados y asignar a los usuarios
        return view('tareas.index', compact('resultado','usuario','estados'));
        }else{
        //sino es así traer tareas por usuario logueado
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
    public function update(Request $request, $id)
    {
        DB::transaction(function() use($request,$id){
        //almacenar parametros recibidos en variables
        $id_tarea = $request->tarea_id;
        $id_esta = $request->est;

        //pasar los string a entero
        is_int($id_esta);
        is_int($id_tarea);
        is_int($id);

        //buscar el proyecto a actualizar el estado
        $pr = Proyecto::FindOrFail($id);

        //$resultad = \DB::select('call cambiar_estado(?,?,?)', array($id_esta,$id,$id_tarea));
        
        //limpiar pelotas
        $pelotas =  collect(DB::insert('call borrar_pelotas(?)', array($id)));

        //obtener máximo numero por proyecto
        $max =  collect(DB::select('call max_id_tarea(?)', array($id)));

        $elmaximo = $max->first()->maximo;
        
        //actualización en detalle de proyecto
        $resultad2 = DB::insert('call cambio_de_jugador(?,?,?,?)', array($id_esta,$id,$id_tarea,$elmaximo));
        
        //consulta del usuario a notificar
        if($id_esta == 3){
        
        //traer maximo id tarea de según el proyecto siempre y cuando el id de la tarea sea 3
        $notificacion1 = DB::select('call notificar_usuario(?,?)', array($id, $id_esta));

        //al maximo sumarle 1 para elegir al siguiente
        $suma = $notificacion1[0]->id_maxima + 1;

        //al maximo dejarlo igual para traer el mismo usuario y comparar

        $suma2 = $notificacion1[0]->id_maxima;

        //traer datos del usuario encontrado como maximo

        $notificacionExtra = collect(DB::select('call notificar_usuario2(?,?)', array($id,$suma2)));

        //traer datos del usuario siguiente
        $notificacion2 = collect(DB::select('call notificar_usuario2(?,?)', array($id,$suma)));

        //obtener el id del usuario encontrado en la tarea maximo
        $var_usuActual = $notificacionExtra[0]->user_id;

        //obtener el id del siguiente usuario
        $var_usuSiguiente = $notificacion2[0]->user_id;

        //si el usuario actual es diferente del usuario siguiente enviar notificacion
        if($var_usuActual!=$var_usuSiguiente){
        //sacar el id del usuario traido
        $var_usu = $notificacion2[0]->user_id;
    
        //notificar al usuario encontrado
        $user = User::find($var_usu);
        $user->notify(new notificarUsuarios($notificacion2));
        }
        }

        //comparar el estado de llegada para registrar acción en el log
        if($id_esta == 1){
            $estado = 'Actualizó un estado a programado en el proyecto' . " " . $pr->proyecto;
        }elseif($id_esta == 2){
            $estado = 'Actualizó un estado a en proceso' . " " . $pr->proyecto;
        }else{
            $estado = 'Actualizó un estado a finalizado' . " " . $pr->proyecto;
        }
        
        $nombre_usu = auth()->user()->name;
        $registro_log = DB::insert('call insertar_log(?,?)', array($nombre_usu,$estado)); 
        
        if(isset($resultad2)){
            return back()->with('success', 'se ha cambiado el estado de la tarea');
        }else{
            return back()->with('danger', 'no se pudo cambiar el estado de la tarea');
        }

        });
        return back();
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
