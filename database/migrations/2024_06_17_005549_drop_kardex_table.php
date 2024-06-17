<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('kardex');
    }

    public function down(): void
    {
        Schema::create('kardex', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->morphs('kardexiable');
            $table->float('total', 8, 2);
            $table->timestamps();
        });
    }
};
