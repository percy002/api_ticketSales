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
        Schema::create('control_ingresos', function (Blueprint $table) {
            $table->bigIncrements('control_ingreso_id');
            $table->unsignedBigInteger('ticket_id');
            $table->string('qr_ticket');
            $table->timestamp('fecha');

            $table->foreign('ticket_id')->references('ticket_id')->on('tickets');
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('control_ingresos');
    }
};
