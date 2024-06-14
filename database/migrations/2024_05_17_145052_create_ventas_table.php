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
            $table->bigIncrements('venta_id');
            $table->unsignedBigInteger('usuario_id')->nullable();
            $table->decimal('monto_total', 8, 2);
            $table->string('tipo_pago');
            $table->timestamp('fecha');
            $table->string('token_pago')->nullable();
            $table->timestamps();

            $table->foreign('usuario_id')->references('usuario_id')->on('usuarios');        
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
