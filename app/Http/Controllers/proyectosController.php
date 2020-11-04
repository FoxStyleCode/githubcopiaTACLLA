<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\Log;

class proyectosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $areas = \DB::select('call traer_areas()');
        $tipos = json_encode(\DB::select('call traer_nombre_tareas()'));
        $data = \DB::select('call listar_proyectos()');
        return view('proyectos.index', compact('data','tipos','areas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = \DB::select('call tipos_de_proyectos()');
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
        if(auth()->user()->can('crear-proyecto')){
        $player = $request->name;
        $numero_p = $request->num;
        $fecha = $request->fech;
        $cliente = $request->cli;
        $nombre_proyecto = $request->nom;
        $predio = $request->ver;
        $municipio = $request->muni;
        $num = $request->tipo;
        is_int($num);

        //almacenar un proyecto
        $resultado = \DB::select('call insetar_proyecto(?,?,?,?,?,?,?,?)',
        array($player,$numero_p,$fecha,$cliente,$nombre_proyecto,
        $predio,$municipio,$num
        ));

        //traer todas las tareas de un tipo de proyecto
            $data = \DB::select('call traer_tareas(?)', array($num));
            foreach($data as $dat){
                 //llamar el ultimo registro de proyectos (id)
                $result = \DB::select('CAll obtener_ultimo_registro()');
                $resultado = end($result); //resultado->id = id del registro del ultimo proyecto
                $insercion = \DB::select('call insertar_tabla_configuracion(?,?,?,?)', array(
                $resultado->id,$dat->id,1,25));
            }
            if(isset($insercion)){
                $estado = 'Creó un nuevo proyecto llamado'. '' .$nombre_proyecto;
                $nombre_usu = auth()->user()->name;
                $registro_log = \DB::select('call insertar_log(?,?)', array($nombre_usu,$estado));
                return redirect('/proyectos')->with('success', 'se ha creado un nuevo proyecto');
            }else{
                return redirect('/proyectos')->with('danger', 'ocurrió un error al crear un nuevo proyecto');
            }
        }else{
            return redirect('/proyectos')->with('danger', 'no tienes los permisos suficientes');
        }
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
        $proyecto = \DB::select('call buscar_proyecto(?)', array($id));
        return view('proyectos.edit', compact('proyecto'));
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
        $player = $request->name;
        $num_p = $request->num;
        $fecha = $request->fech;
        $cliente = $request->cli;
        $nom_p = $request->nom;
        $vereda = $request->ver;
        $municipio = $request->muni;
        $resultado = \DB::select('call actualizar_proyecto(?,?,?,?,?,?,?,?)', array($id,
        $player,$num_p,$fecha,$cliente,$nom_p,$vereda,$municipio
        ));  
        
        if(isset($resultado)){
                $estado = 'Actualizó el proyecto' . $nom_p;
                $nombre_usu = auth()->user()->name;
                $registro_log = \DB::select('call insertar_log(?,?)', array($nombre_usu,$estado));
            return redirect('/proyectos')->with('success', 'proyecto actualizado correctamente');
        }else{
            return redirect('/proyectos')->with('danger', 'error al actualizar el proyecto');
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
