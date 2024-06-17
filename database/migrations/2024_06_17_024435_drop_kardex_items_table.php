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
       
        Schema::table('kardex_items', function (Blueprint $table) {
            $table->dropForeign(['kardex_id']); // Elimina la clave foránea 'kardex_id'
        });
        // Borrar la tabla kardex_items si existe
        Schema::dropIfExists('kardex_items');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Crear la tabla kardex_items
        Schema::create('kardex_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kardex_id')->constrained('kardex')->onDelete('cascade');
            $table->foreignId('producto_id')->constrained('Productos')->onDelete('cascade');
            $table->unsignedBigInteger('cantidad');
            $table->float('precio_unitario', 8, 2);
            $table->float('total', 8, 2);
            $table->timestamps();
        });
    }
};
