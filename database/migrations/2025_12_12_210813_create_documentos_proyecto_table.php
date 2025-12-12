<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documentos_proyecto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proyecto_id')->constrained('proyectos')->onDelete('cascade');
            $table->string('nombre'); // Nombre del documento
            $table->text('descripcion')->nullable();
            $table->string('ruta'); // Ruta del archivo en storage
            $table->string('tipo'); // imagen, pdf, word, txt, otro
            $table->string('extension'); // jpg, png, pdf, docx, txt
            $table->integer('tamanio')->nullable(); // Tamaño en bytes
            $table->foreignId('subido_por')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documentos_proyecto');
    }
};