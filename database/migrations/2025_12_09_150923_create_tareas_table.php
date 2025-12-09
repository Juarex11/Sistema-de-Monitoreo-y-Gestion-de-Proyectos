<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('tareas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proyecto_id');

            $table->string('titulo');
            $table->text('descripcion')->nullable();

            $table->enum('estado', ['pendiente', 'en_progreso', 'completada'])
                  ->default('pendiente');

            $table->timestamps();

            $table->foreign('proyecto_id')->references('id')->on('proyectos')->onDelete('cascade');
        });
    }

    public function down() {
        Schema::dropIfExists('tareas');
    }
};
