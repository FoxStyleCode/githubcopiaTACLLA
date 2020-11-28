<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Log;
use App\User;
use App\tipo_de_proyecto;

class proyectosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //lenar combos para crear tareas y crear tipos de proyectos
        $areas = DB::select('call traer_areas()');
        $tipos = json_encode(DB::select('call traer_nombre_tareas()'));
        //$data = \DB::select('call listar_proyectos()');
        $data = DB::select('call esta()');
    //    $data = \DB::table('proyectos')
    //    ->join('tipo_de_proyectos','proyectos.tipo_de_proyecto_id', '=', 'tipo_de_proyectos.id')
    //    ->where('estado', '1' )
    //    ->select('proyectos.*', 'tipo_de_proyectos.nombre')
    //    ->paginate(5);

        return view('proyectos.index', compact('data','tipos','areas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //llenar select para elegir el tipo de proyecto al crear un nuevo proyecto
        $data = DB::select('call tipos_de_proyectos()');
        return view('proyectos.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //validar los campos del nombre de proyecto, el número y el predio
        $request->validate([

            'nombreproyecto' => 'required',
            'numeroproyecto' => 'required',
            'predio' =>'required',
            

        ]);

        //abrimos una transacción por si ocurre algún error 
        
        DB::transaction(function() use($request){

        //si el usuario tiene permisos de crear proyecto
        if(auth()->user()->can('crear-proyecto')){

        //se guarda el proyecto
        $numero_p = $request->numeroproyecto;
        $fecha = $request->fech;
        $cliente = $request->cli;
        $nombre_proyecto = $request->nombreproyecto;
        $predio = $request->predio;
        $municipio = $request->muni;
        $num = $request->tipo;
        is_int($num);

        //almacenar un proyecto
        $resultado = DB::insert('call insetar_proyecto(?,?,?,?,?,?,?)',
        array($numero_p,$fecha,$cliente,$nombre_proyecto,
        $predio,$municipio,$num
        ));

        //traer todas las tareas de un tipo de proyecto
            $data = DB::select('call traer_tareas(?)', array($num));
            foreach($data as $dat){
                //traer usuarios con los roles de lideres
                $lider1 = User::role('COM.LDR')->get();
                $lider2 = User::role('ADM.LDR')->get();
                $lider3 = User::role('OPR.LDR')->get();
                $lider4 = User::role('I+D.LDR')->get();
                //llamar el ultimo registro de proyectos (id)
                $result = DB::select('CAll obtener_ultimo_registro()');
                $resultado = end($result); //resultado->id = id del registro del ultimo proyecto
                //si el id del área es 1 entonces guarda al lider del área comercial
                if($dat->area_id==1){
                $insercion = DB::insert('call insertar_tabla_configuracion(?,?,?,?,?)', array(
                $resultado->id,$dat->id,1,$lider1[0]->id,1));
                }
                //si el id del área es 2 entonces guarda al lider del área administrativa
                else if($dat->area_id==2){
                $insercion = DB::insert('call insertar_tabla_configuracion(?,?,?,?,?)', array(
                $resultado->id,$dat->id,1,$lider2[0]->id,0));
                }
                //si el id del área es 3 entonces guarda al lider del área de operaciones
                else if($dat->area_id==3){
                $insercion = DB::insert('call insertar_tabla_configuracion(?,?,?,?,?)', array(
                $resultado->id,$dat->id,1,$lider3[0]->id,0));
                }
                //si el id del área es 4 entonces guarda al lider del área de desarrollo
                else if($dat->area_id==4){
                $insercion = DB::insert('call insertar_tabla_configuracion(?,?,?,?,?)', array(
                $resultado->id,$dat->id,1,$lider4[0]->id,0));
                }
            }

            //guardar acción en el log
            if(isset($insercion)){
                $estado = 'Creó un nuevo proyecto llamado'. '' .$nombre_proyecto;
                $nombre_usu = auth()->user()->name;
                $registro_log = DB::insert('call insertar_log(?,?)', array($nombre_usu,$estado));
                return redirect('/proyectos')->with('success', 'se ha creado un nuevo proyecto');
            }else{
                return redirect('/proyectos')->with('danger', 'ocurrió un error al crear un nuevo proyecto');
            }
        }else{
            return redirect('/proyectos')->with('danger', 'no tienes los permisos suficientes');
        }
        });
            return redirect('/proyectos');
        /*
        
        //si existe un resultado de la inserción redireccioname al 
        //inicio
        if(isset($resultado)){
            return redirect('/proyectos')->with('success', 'se ha creado un nuevo proyecto');;
        }
        */
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     //cerrar un proyecto
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        //editar tipo de proyecto
        $data = tipo_de_proyecto::all();
        $proyecto = DB::select('call buscar_proyecto(?)', array($id));
        return view('proyectos.edit', compact('proyecto','data'));
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
        //actualizar un proyecto
        $eltipo = $request->tipo;
        is_int($eltipo);

        $proyecto = DB::select('call buscar_proyecto(?)', array($id));
        is_int($proyecto[0]->tipo_de_proyecto_id);

        if($proyecto[0]->tipo_de_proyecto_id==$eltipo){
        $num_p = $request->num;
        $fecha = $request->fech;
        $cliente = $request->cli;
        $nom_p = $request->nom;
        $vereda = $request->ver;
        $municipio = $request->muni;
        $resultado = DB::insert('call actualizar_proyecto(?,?,?,?,?,?,?)', array($id,
        $num_p,$fecha,$cliente,$nom_p,$vereda,$municipio
        ));  
        
        if(isset($resultado)){
                $estado = 'Actualizó el proyecto' . $nom_p;
                $nombre_usu = auth()->user()->name;
                $registro_log = DB::insert('call insertar_log(?,?)', array($nombre_usu,$estado));
            return redirect('/proyectos')->with('success', 'proyecto actualizado correctamente');
        }else{
            return redirect('/proyectos')->with('danger', 'error al actualizar el proyecto');
        }
        }else{
            $borrar_proyecto_de_detalle = DB::insert('call eliminar_d_p_a_p(?)', array($id));
            $borrar_proyecto = DB::insert('call eliminar_p_a_p(?)', array($id));
        
            $numero_p = $request->num;
            $fecha = $request->fech;
            $cliente = $request->cli;
            $nombre_proyecto = $request->nom;
            $predio = $request->ver;
            $municipio = $request->muni;
            $num = $request->tipo;
            is_int($num);

            //almacenar un proyecto
            $resultado = DB::insert('call insetar_proyecto(?,?,?,?,?,?,?)',
            array($numero_p,$fecha,$cliente,$nombre_proyecto,
            $predio,$municipio,$num));

             //traer todas las tareas de un tipo de proyecto
             $data = DB::select('call traer_tareas(?)', array($num));
             foreach($data as $dat){
                  //traer usuarios con los roles de lideres
                $lider1 = User::role('COM.LDR')->get();
                $lider2 = User::role('ADM.LDR')->get();
                $lider3 = User::role('OPR.LDR')->get();
                $lider4 = User::role('I+D.LDR')->get();
                //llamar el ultimo registro de proyectos (id)
                $result = DB::select('CAll obtener_ultimo_registro()');
                $resultado = end($result); //resultado->id = id del registro del ultimo proyecto
                //si el area es comercial inserta al lider comercial
                if($dat->area_id==1){
                $insercion = DB::insert('call insertar_tabla_configuracion(?,?,?,?,?)', array(
                $resultado->id,$dat->id,1,$lider1[0]->id,1));
                }
                //si el area es administrativa inserta al lider del area administrativa
                else if($dat->area_id==2){
                $insercion = DB::insert('call insertar_tabla_configuracion(?,?,?,?,?)', array(
                $resultado->id,$dat->id,1,$lider2[0]->id,0));
                }
                //si el area es de operaciones insertar al lider de operaciones
                else if($dat->area_id==3){
                $insercion = DB::insert('call insertar_tabla_configuracion(?,?,?,?,?)', array(
                $resultado->id,$dat->id,1,$lider3[0]->id,0));
                }
                //si el area es de desarrollo inserta al lider del area de desarrollo
                else if($dat->area_id==4){
                $insercion = DB::insert('call insertar_tabla_configuracion(?,?,?,?,?)', array(
                $resultado->id,$dat->id,1,$lider4[0]->id,0));
                }
                //llamar el ultimo registro de proyectos (id)
                //  $result = DB::select('CAll obtener_ultimo_registro()');
                //  $resultado = end($result); //resultado->id = id del registro del ultimo proyecto
                //  $insercion = DB::insert('call insertar_tabla_configuracion(?,?,?,?,?)', array(
                //  $resultado->id,$dat->id,1,25,1));
             }
             //guardar acciones en el log
             if(isset($insercion)){
                 $estado = 'Actualizó el proyecto'. '' .$nombre_proyecto;
                 $nombre_usu = auth()->user()->name;
                 $registro_log = DB::insert('call insertar_log(?,?)', array($nombre_usu,$estado));
                 return redirect('/proyectos')->with('success', 'proyecto actualizado correctamente');
             }else{
                 return redirect('/proyectos')->with('danger', 'ocurrió un error al actualizar un proyecto');
             }
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
