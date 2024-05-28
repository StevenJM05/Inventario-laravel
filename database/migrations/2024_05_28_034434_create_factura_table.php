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
        Schema::create('factura', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->string('cliente');
            $table->unsignedBigInteger('numero_factura');
            $table->float('total', 8, 2);
            $table->float('impuesto', 8, 2);
            $table->float('total_con_impuesto', 8, 2);
            $table->string('direccion');
            $table->morphs('facturable');
            $table->ForeignId('usuario_id')->constrained('usuario')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factura');
    }
};
