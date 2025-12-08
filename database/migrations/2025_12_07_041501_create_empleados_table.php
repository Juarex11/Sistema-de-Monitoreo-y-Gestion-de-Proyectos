<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::create('empleados', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('user_id')->unique();

        // Datos del empleado
        $table->string('cargo')->nullable();
        $table->string('celular')->nullable();
        $table->string('direccion')->nullable();
        $table->string('carrera')->nullable();
        $table->string('ciclo')->nullable();
        $table->decimal('remuneracion', 10, 2)->nullable();
        $table->text('otros_datos')->nullable();

        $table->timestamps();

        // Relación con users
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}

};
