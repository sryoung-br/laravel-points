<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColaboradoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('colaboradores', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('sobrenome');
            $table->string('cpf');
            $table->string('pis');
            $table->string('centro_custo');
            $table->string('matricula');
            $table->dateTime('data_admissao');
            $table->string('cargo');

            $table->unsignedBigInteger('equipe_id');
            $table->foreign('equipe_id')->references('id')->on('equipes');

            // $table->unsignedBigInteger('turno_id');
            // $table->foreign('turno_id')->references('id')->on('turnos');

            // $table->unsignedBigInteger('controle_ponto_id');
            // $table->foreign('controle_ponto_id')->references('id')->on('controle_pontos');

            $table->boolean('registra_ponto');
            $table->boolean('clt');
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('colaborador_id')->after('password');
            $table->foreign('colaborador_id')->references('id')->on('colaboradores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('colaboradores');
    }
}
