<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateControlePontosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('controle_pontos', function (Blueprint $table) {
            // Geral
            $table->id();
            $table->string("nome");
            $table->enum('horario_padrao', ['utc-3', 'utc-1','utc-2','utc-0','utc+1','utc+2', 'utc+3'])->default('utc-3');
            $table->boolean('aplicar_intervalo');

            // Tolerância
            $table->boolean('habilitar_tolerancia');
            $table->decimal('tempo_limite')->nullable();

            // Hora extra
            $table->decimal('primeira_fase')->default('50.00');
            $table->decimal('segunda_fase')->default('100.00');

            // Banco de horas
            $table->boolean('habilitar_banco_horas');
            $table->time('limite_horas_positiva')->nullable();
            $table->time('limite_horas_negativa')->nullable();

            // Adicional noturno
            $table->boolean('habilitar_adicional_noturno');
            $table->time('horario_inicial')->nullable();
            $table->time('horario_final')->nullable();

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
        Schema::dropIfExists('controle_pontos');
    }
}
