<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Auth\Access\Gate;
use Illuminate\Support\Facades\DB;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        //solo usuarios que puedan crear, actualizar, leer y eliminar roles podrán ingresar
        $this->middleware(['permission:crear-role|leer-roles|actualizar-role|eliminar-role'], ['only' => ['create', 'store', 'edit', 'destroy']]);
        
    }


    public function index()
    {

        //si el usuario puede leer roles entonces mostrarle la lista de roles
        if(auth()->user()->can('leer-roles')){
        $roles = Role::all();

        return view('roles.index', compact('roles'));

        }else{
            return redirect('/home')->with('danger', 'No permitido entrar a esta sección');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //listar permisos en la ventana create
        $permisos = Permission::all()->pluck('name','id');
        return view('roles.create', compact('permisos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //iniciamos una transacción por ocurre una interrupción
        DB::transaction(function() use($request){
        //si el usuario está autorizado para crear roles entonces
        if(auth()->user()->can('crear-role')){
        //hacer uso del modelo para crear un role
        $role = new Role;

        //agregar nombre al role
        $role->name = $request->namerole;

        //guardar el role
        $role->save();

        //asignar los permisos al role
        $role->givePermissionTo($request->permisos);

        //insertar en el log
        $estado = 'Creó un nuevo role llamado'. ' ' . $request->namerole;
        $nombre_usu = auth()->user()->name;
        $registro_log = DB::insert('call insertar_log(?,?)', array($nombre_usu,$estado));
        return redirect('/roles')->with('success', 'Role agregado correctamente');
        }else{
            return redirect('/roles')->with('danger', 'No tienes permisos para crear un role');
        }
        });
        return redirect('/roles');
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
        if(auth()->user()->can('actualizar-role')){
        $roles = Role::findOrFail($id);
        if($roles->name == "SPR.TMG"){
            return redirect('/roles')->with('danger', 'No puedes editar al super administrador');
        }else{
        $permissions = Permission::get();
        $assignedPermissions = $roles->permissions->pluck('id')->toArray(); 
        //$permisos = $roles->hasPermissionTo(Permission::all());
        
        return view('roles.edit', compact('roles','permissions', 'assignedPermissions'));
        }
        }else{
            return redirect('/roles')->with('danger', 'No tienes permisos para editar este role');
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
        DB::transaction(function() use($request,$id){
        if(auth()->user()->can('actualizar-role')){
        $roles = Role::findOrFail($id);

        $roles->permissions()->sync($request->get('permissions'));

        $roles->name = $request->namerole;

        $roles->update();

        $estado = 'Actualizó el role llamado'. ' ' . $request->namerole;
        $nombre_usu = auth()->user()->name;
        $registro_log = DB::select('call insertar_log(?,?)', array($nombre_usu,$estado));

        return redirect('/roles')->with('success', 'Role actualizado correctamente');

        }else{
            return redirect('/roles')->with('danger', 'No tienes permisos para actualizar este role');
        }
        });

        return redirect('/roles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        DB::transaction(function() use($id){
        if(auth()->user()->can('eliminar-role')){

        $roles = Role::findOrFail($id);
        
        if($roles->name == "SPR.TMG"){
            return redirect('/roles')->with('danger', 'No puedes eliminar al super rol SPR.TMG');
        }else{

        if($roles->delete()){
            $estado = 'Eliminó el role llamado' . " " . $roles->name;
            $nombre_usu = auth()->user()->name;
            $registro_log = DB::insert('call insertar_log(?,?)', array($nombre_usu,$estado));
            
            return redirect('/roles')->with('danger', 'Eliminado correctamente');
        }else{
            return response()->json([
                "mensaje" => "error al eliminar usuario"
            ]);
            }
        }

    }else{
        return redirect('/roles')->with('danger', 'Este usuario no puede eliminar un role'); 
    }

    });

    return back();

    }
}
