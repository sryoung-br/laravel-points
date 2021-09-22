<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTurnoHorariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turno_horarios', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('turno_id');
            $table->foreign('turno_id')->references('id')->on('turnos');

            $table->unsignedBigInteger('turno_semana_id');
            $table->foreign('turno_semana_id')->references('id')->on('turno_semanas');

            $table->time('entrada');
            $table->time('saida');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('turno_horarios');
    }
}
