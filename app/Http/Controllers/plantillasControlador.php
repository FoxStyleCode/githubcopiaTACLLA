<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class plantillasControlador extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $resultado = \DB::select('call traer_plantillas()');
        return view('plantillas.index', compact('resultado'));
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
        $name_p = $request->namep;
        $enlace_p = $request->enlacep;
        
        if($archivo=$request->file('file')){
            $nombre = $archivo->getClientOriginalName();
            $archivo->move('imagenes',$nombre); 
        }

        $resultado = \DB::select('call insertar_plantilla(?,?,?)', array($nombre, $name_p, $enlace_p)); 
        
        if(isset($resultado)){
            return back()->with('success', 'plantilla añadida correctamente');
        }else{
            return back()->with('danger', 'no se añadió la plantilla');
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
        $resultado = \DB::select('call eliminar_plantilla(?)', array($id)); 
        if(isset($resultado)){
            return back()->with('success', 'plantilla removida correctamente');
        }else{
            return back()->with('danger', 'no se pudo remover la plantilla');
        }
    }
}
