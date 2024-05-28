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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->ForeignId('usuario_id')->constrained('usuario')->onDelete('cascade');
            $table->float('descuentos_adicionales', 8, 2);
            $table->unsignedBigInteger('cantidad_total');
            $table->float('subtotal', 8, 2);
            $table->float('descuentos_totales', 8, 2);
            $table->float('total_impuestos', 8, 2);
            $table->float('total', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
