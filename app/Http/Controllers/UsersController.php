<?php

namespace App\Http\Controllers;

use App\User;
use App\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;


class UsersController extends Controller
{


    public function __construct()
    {
        $this->middleware(['permission:crear-usuario|leer-usuarios|actualizar-usuario|eliminar-usuario'], ['only' => ['create', 'store', 'edit', 'destroy']]);
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::where('estado',1)->get();
        return view('usuarios.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all()->pluck('name','id');
        $areas = Area::all();
        return view('usuarios.create', compact('roles','areas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $usuario = new User;

        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = $request->password;
        $usuario->area_id = $request->area;
        $usuario->estado = 1;

        request()->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$usuario->id,
            'password' => '',
        ]);

        if ($usuario->save()) {
            $estado = 'Añadió un nuevo usuario llamado'. ' ' . $request->name;
            $nombre_usu = auth()->user()->name;
            $registro_log = DB::insert('call insertar_log(?,?)', array($nombre_usu,$estado));
            $usuario->assignRole($request->role);
            return redirect('/usuarios')->with('success','usuario creado correctamente');
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
        if(auth()->user()->can('actualizar-usuario')){
        $usuario = User::findOrFail($id);
        $roles = Role::all()->pluck('name','id');
        return view('usuarios.edit', compact('usuario', 'roles'));
        
    }else{
        return redirect('/usuarios')->with('danger', 'No tienes los permisos suficientes'); 
    }
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
        if(auth()->user()->can('actualizar-usuario')){
        $usuario = User::findOrFail($id);

        $usuario->name = $request->name;
        $usuario->email = $request->email;
        
        if($request->password != null){
            $usuario->password = $request->password;
        }

        $usuario->syncRoles($request->role);

        $usuario->save(); 

        $estado = 'Actualizó al usuario'. ' ' . $request->name;
        $nombre_usu = auth()->user()->name;
        $registro_log = DB::insert('call insertar_log(?,?)', array($nombre_usu,$estado));

        return redirect('/usuarios')->with('success', 'usuario actualizado correctamente');
    }else{
        return redirect('/usuarios')->with('danger', 'No tienes permisos para actualizar a este usuario'); 
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
        if(auth()->user()->can('eliminar-usuario')){
        $usuario = User::FindOrFail($id);

        if($usuario->name == "Ariel"){
        return redirect('/usuarios')->with('danger', 'No puedes eliminar al super administrador');
        }else{


        if($usuario->hasAnyRole()){
        $usuario->removeRole($usuario->roles->implode('name','id'));
        }

        if($usuario->delete()){
            $estado = 'Eliminó un usuario llamado' . " " . $usuario->name;
            $nombre_usu = auth()->user()->name;
            $registro_log = DB::insert('call insertar_log(?,?)', array($nombre_usu,$estado));
            return redirect('/usuarios')->with('danger', 'usuario eliminado correctamente');
            // return redirect('/usuarios')->with('eliminar', 'eliminado');
        }else{
            return response()->json([
                "mensaje" => "error al eliminar usuario"
            ]);
        }
    }
    }else{
        return redirect('/usuarios')->with('danger', 'No tienes permisos para eliminar a este usuario'); 
    }
       
    }
}
