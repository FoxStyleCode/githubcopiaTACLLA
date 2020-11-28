<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class linkController extends Controller
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
        //traer todos los enlaces por proyecto para listarlos en la vista
        $resultado = DB::select('call traer_nombre_enlace(?)', array($id));
        if(isset($resultado)){
            return view('links.index', compact('resultado'));
        }else{
            return redirect('/links')->with('danger', 'ocurrió un error');
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
        //validar que se reciban parametros (id del proyecto, el enlace y el id de la tarea)
        $act_link = DB::insert('call actualizar_link(?,?,?)', array(
            $request->enlac,
            $id,
            $request->tarea_id
        ));
        if(isset($act_link)){
            return back()->with('success', 'Añadido un nuevo enlace');
        }else{
            return back()->with('danger', 'No se pudo añadir el nuevo enlace');
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
