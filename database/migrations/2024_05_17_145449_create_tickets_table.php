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
        Schema::create('tickets', function (Blueprint $table) {
            $table->bigIncrements('ticket_id');
            $table->unsignedBigInteger('venta_id');
            $table->unsignedBigInteger('tipo_ticket_id');           
            
            $table->string('turno');
            $table->integer('cantidad');
            $table->decimal('precio', 8, 2);
            $table->string('QR_ticket');
            $table->timestamps();
            
            $table->foreign('tipo_ticket_id')->references('tipo_ticket_id')->on('tipos_tickets');
            $table->foreign('venta_id')->references('venta_id')->on('ventas');
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
