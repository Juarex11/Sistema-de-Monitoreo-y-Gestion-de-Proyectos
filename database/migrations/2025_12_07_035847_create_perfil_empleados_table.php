<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 public function up()
{
    Schema::create('perfil_empleados', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id')->unique();

        // Datos laborales
        $table->string('cargo')->nullable();
        $table->string('area')->nullable();
        $table->decimal('remuneracion', 10, 2)->nullable();
        $table->date('fecha_ingreso')->nullable();
        $table->string('turno')->nullable();

        // Datos personales
        $table->string('celular')->nullable();
        $table->string('direccion')->nullable();
        $table->string('carrera')->nullable();
        $table->string('ciclo')->nullable();
        $table->date('fecha_nacimiento')->nullable();

        // Extras
        $table->text('observaciones')->nullable();

        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}

};
