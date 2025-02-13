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
        Schema::create('actividades', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('descripcion');
            $table->unsignedBigInteger('id_tipo_actividad');
            $table->unsignedBigInteger('id_centro_civico');
            $table->unsignedBigInteger('id_monitor');
            
            $table->foreign('id_tipo_actividad')->references('id')->on('tipos_actividades');
            $table->foreign('id_centro_civico')->references('id')->on('centros_civicos');
            $table->foreign('id_monitor')->references('id')->on('monitores');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actividades');
    }
};