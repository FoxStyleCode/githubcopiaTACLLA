<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()['cache']->forget('spatie.permission.cache');

       Permission::create(['name' => 'create user']);
       Permission::create(['name' => 'read users']);
       Permission::create(['name' => 'update user']);
       Permission::create(['name' => 'delete user']);

       Permission::create(['name' => 'crear-role']);
       Permission::create(['name' => 'leer-roles']);
       Permission::create(['name' => 'actualizar-role']);
       Permission::create(['name' => 'eliminar-role']);

       Permission::create(['name' => 'crear-usuario']);
       Permission::create(['name' => 'leer-usuarios']);
       Permission::create(['name' => 'actualizar-usuario']);
       Permission::create(['name' => 'eliminar-usuario']);

       $role = Role::create(['name' => 'editor']);
       $role->givePermissionTo(['read users']);
       $role->givePermissionTo(['update user']);

       $role = Role::create(['name' => 'moderador']);
       $role->givePermissionTo(['crear-role']);
       $role->givePermissionTo(['leer-roles']);
       $role->givePermissionTo(['actualizar-role']);
       $role->givePermissionTo(['eliminar-role']);

       $role->givePermissionTo(['crear-usuario']);
       $role->givePermissionTo(['leer-usuarios']);
       $role->givePermissionTo(['actualizar-usuario']);
       $role->givePermissionTo(['eliminar-usuario']);


       $role = Role::create(['name' => 'SPR.TMG']);
       $role->givePermissionTo(Permission::all());
    }
}
