<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColaboradoresTurnoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('colaboradores', function (Blueprint $table) {

            $table->unsignedBigInteger('turno_id')->nullable()->after('equipe_id');
            $table->foreign('turno_id')->references('id')->on('turnos');

            $table->unsignedBigInteger('controle_ponto_id')->nullable()->after('turno_id');
            $table->foreign('controle_ponto_id')->references('id')->on('controle_pontos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
