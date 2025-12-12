<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabla principal de equipos
        Schema::create('equipos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->foreignId('proyecto_id')->nullable()->constrained('proyectos')->onDelete('set null');
            $table->enum('estado', ['activo', 'inactivo', 'finalizado'])->default('activo');
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->text('objetivos')->nullable(); // Objetivos del equipo
            $table->integer('capacidad_maxima')->nullable(); // Cantidad máxima de miembros
            $table->string('ubicacion')->nullable(); // Oficina, remoto, híbrido
            $table->text('notas')->nullable();
            $table->foreignId('creado_por')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });

        // Tabla pivot: equipo_user (miembros del equipo)
        Schema::create('equipo_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipo_id')->constrained('equipos')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('rol_equipo', ['lider', 'miembro'])->default('miembro');
            $table->date('fecha_asignacion')->default(now());
            $table->date('fecha_salida')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
            
            // Un usuario no puede estar duplicado en el mismo equipo
            $table->unique(['equipo_id', 'user_id']);
        });

        // Tabla para proyectos adicionales del equipo (si un equipo trabaja en múltiples proyectos)
        Schema::create('equipo_proyecto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipo_id')->constrained('equipos')->onDelete('cascade');
            $table->foreignId('proyecto_id')->constrained('proyectos')->onDelete('cascade');
            $table->date('fecha_asignacion')->default(now());
            $table->timestamps();
            
            $table->unique(['equipo_id', 'proyecto_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipo_proyecto');
        Schema::dropIfExists('equipo_user');
        Schema::dropIfExists('equipos');
    }
};