<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('proyectos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('nombre_proyecto');
            $table->text('descripcion')->nullable();

            $table->unsignedBigInteger('responsable_id')->nullable();
            $table->unsignedBigInteger('cliente_id')->nullable();

            $table->enum('estado', ['pendiente', 'en_progreso', 'pausado', 'finalizado', 'cancelado'])
                  ->default('pendiente');

            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->date('fecha_cierre_real')->nullable();

            $table->decimal('presupuesto_asignado', 12,2)->nullable();
            $table->decimal('presupuesto_ejecutado', 12,2)->nullable();

            $table->string('lugar')->nullable();
            $table->string('tipo_proyecto')->nullable();
            $table->string('prioridad')->nullable();

            $table->unsignedBigInteger('creado_por')->nullable();
            $table->unsignedBigInteger('actualizado_por')->nullable();

            $table->timestamps();

            // Relaciones
            $table->foreign('responsable_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('set null');
            $table->foreign('creado_por')->references('id')->on('users')->onDelete('set null');
            $table->foreign('actualizado_por')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down() {
        Schema::dropIfExists('proyectos');
    }
};
