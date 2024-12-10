<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atividades', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('eixo_id');
            $table->foreign('eixo_id')->references('id')->on('eixos')->onDelete('restrict');
            $table->text('atividade_descricao');
            $table->text('objetivo');
            $table->string('publico_alvo',255);
            $table->string('tipo_evento',255);
            $table->string('canal_divulgacao',255);
            $table->date('data_prevista');
            $table->date('data_realizada');
            $table->integer('meta');
            $table->integer('realizado');
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
        Schema::dropIfExists('atividades');
    }
};
