<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    public function up()
    {
      Schema::create('clientes', function (Blueprint $table) {
    $table->id();

    $table->string('codigo')->unique();
    $table->enum('tipo_cliente', ['persona', 'empresa'])->default('empresa');

    $table->string('nombre_comercial')->nullable();
    $table->string('razon_social')->nullable();

    $table->string('ruc_dni', 20)->unique();

    $table->string('representante')->nullable();
    $table->string('telefono', 20)->nullable();
    $table->string('telefono_alt', 20)->nullable();

    $table->string('email')->nullable();
    $table->string('email_alt')->nullable();

    $table->string('direccion')->nullable();
    $table->string('ciudad')->nullable();
    $table->string('pais')->nullable();

    $table->string('actividad')->nullable();

    $table->enum('estado_cliente', ['activo', 'inactivo'])->default('activo');

    $table->unsignedBigInteger('creado_por')->nullable();
    $table->unsignedBigInteger('actualizado_por')->nullable();

    // Relaciones
    $table->foreign('creado_por')->references('id')->on('users')->nullOnDelete();
    $table->foreign('actualizado_por')->references('id')->on('users')->nullOnDelete();
});


    public function down()
    {
        Schema::dropIfExists('clientes');
    }
}
