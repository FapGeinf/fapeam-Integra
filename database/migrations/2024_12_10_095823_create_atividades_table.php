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
            $table->text('atividade_descricao')->nullable();
            $table->text('objetivo')->nullable();
            $table->string('tipo_evento',255)->nullable();
            $table->date('data_prevista')->nullable();
            $table->date('data_realizada')->nullable();
            $table->integer('meta')->nullable();
            $table->integer('realizado')->nullable();
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
