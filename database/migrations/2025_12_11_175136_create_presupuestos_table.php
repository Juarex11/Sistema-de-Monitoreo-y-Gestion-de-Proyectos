<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('presupuestos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('proyecto_id')->constrained('proyectos')->onDelete('cascade');
        $table->string('nombre');
        $table->decimal('precio', 10, 2);
        $table->timestamps();
    });
}

};
