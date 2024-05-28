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
        Schema::create('ventas_items', function (Blueprint $table) {
            $table->id();
            $table->ForeignId('venta_id')->constrained('ventas')->onDelete('cascade');
            $table->ForeignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->unsignedBigInteger('cantidad');
            $table->float('descuento', 8, 2);
            $table->float('precio_unidad', 8, 2);
            $table->float('impuesto', 8, 2);
            $table->float('total', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas_items');
    }
};
