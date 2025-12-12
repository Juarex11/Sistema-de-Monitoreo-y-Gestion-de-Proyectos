<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cotizacion_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cotizacion_id')
                  ->constrained('cotizaciones')
                  ->onDelete('cascade');
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->decimal('precio', 12, 2);
            $table->enum('tipo_pago', ['unico', 'mensual', 'anual'])->default('unico');
            $table->boolean('aplica_igv')->default(false);
            $table->decimal('total', 12, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cotizacion_items');
    }
};
