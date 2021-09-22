<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->string('cnpj')->unique();
            $table->string('nome')->nullable();
            $table->string('razao_social');
            $table->string('inscricao_estadual')->nullable();
            $table->boolean('empregadora')->nullable();
            $table->string('cei_ceno')->nullable();
            $table->string('logotipo')->nullable();
            $table->text('notas_observacoes')->nullable();

            $table->unsignedBigInteger('contato_id')->nullable();
            $table->foreign('contato_id')->references('id')->on('contatos');

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
        Schema::dropIfExists('empresas');
    }
}
