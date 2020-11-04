<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //usuario con el rol editor

        $editor = User::create([
            'name' => 'editor',
            'email' => 'editor@gmail.com',
            'password' => bcrypt('123456')
        ]);

        $editor->assignRole('editor');

        //moderador
        $moderador = User::create([
            'name' => 'moderador',
            'email' => 'moderador@gmail.com',
            'password' => bcrypt('123456')
        ]);

        $moderador->assignRole('moderador');


        //superadministrador
        $Ariel = User::create([
            'name' => 'Ariel',
            'email' => 'ariel@taclla.com',
            'password' => bcrypt('123456')
        ]);

        $Ariel->assignRole('SPR.TMG');
    }
}
