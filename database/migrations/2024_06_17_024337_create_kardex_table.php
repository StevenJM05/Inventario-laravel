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
        Schema::create('kardex', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('producto_id');
            $table->morphs('transaccionable'); // Relación polimórfica
            $table->integer('cantidad');
            $table->decimal('precio_unitario', 10, 2);
            $table->decimal('total', 10, 2);
            $table->enum('tipo_movimiento', ['entrada', 'salida']);
            $table->integer('stock_anterior');
            $table->integer('stock_actual');
            $table->date('fecha');
            $table->timestamps();

            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kardex');
    }
};
