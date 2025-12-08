<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // referencia al usuario
            $table->string('name');                // nombre del documento
            $table->string('file');                // ruta del PDF
            $table->date('date');                  // fecha del documento
            $table->string('uploaded_by');         // nombre del usuario que sube
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_documents');
    }
};
