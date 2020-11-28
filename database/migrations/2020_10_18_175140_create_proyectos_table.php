<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProyectosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyectos', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('player');
            $table->string('area');
            $table->string('etapa');
            $table->string('pryct');
            $table->date('fecha');
            $table->string('cliente');
            $table->string('proyecto');
            $table->string('predio');
            $table->string('municipio');
            $table->unsignedBigInteger('tipo_de_proyecto_id');
            $table->foreign('tipo_de_proyecto_id')->references('id')->on('tipo_de_proyectos');
            $table->integer('estado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proyectos');
    }
}
