<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo');
            $table->string('nombre');
            $table->string('descripcion');
            $table->ForeignId('marca_id')->constrained('marca');
            $table->ForeignId('categorias_id')->constrained('categorias');
            $table->ForeignId('Unidad_medida_id')->constrained('unidad_medida');
            $table->boolean('is_available')->default(true);
            $table->unsignedBigInteger('stock');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
