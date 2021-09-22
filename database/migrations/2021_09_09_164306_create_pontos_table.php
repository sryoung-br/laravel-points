<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePontosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pontos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('colaborador_id');
            $table->foreign('colaborador_id')->references('id')->on('colaboradores');

            $table->timestamps();

            $table->unsignedBigInteger('turno_semana_id');
            $table->foreign('turno_semana_id')->references('id')->on('turno_semanas');

            $table->unsignedBigInteger('turno_horario_id');
            $table->foreign('turno_horario_id')->references('id')->on('turno_horarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pontos');
    }
}
