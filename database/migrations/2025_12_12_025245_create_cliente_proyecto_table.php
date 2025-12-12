<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cliente_proyecto', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('cliente_id')
                  ->constrained('clientes')
                  ->onDelete('cascade');
            
            $table->foreignId('proyecto_id')
                  ->constrained('proyectos')
                  ->onDelete('cascade');

            $table->timestamps();

            // Evita duplicados
            $table->unique(['cliente_id', 'proyecto_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cliente_proyecto');
    }
};
