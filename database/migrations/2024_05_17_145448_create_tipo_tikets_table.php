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
        Schema::create('tipos_tickets', function (Blueprint $table) {
            $table->bigIncrements('tipo_ticket_id');
            $table->string('nombre',100);
            $table->decimal('precio', 8, 2);
            $table->string('turno',30);
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_tikets');
    }
};
