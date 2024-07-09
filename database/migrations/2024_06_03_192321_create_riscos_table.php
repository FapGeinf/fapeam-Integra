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
        Schema::create('riscos', function (Blueprint $table) {
            $table->id();
            $table->string('responsavelRisco');
            $table->string('riscoEvento',4500);
            $table->string('riscoCausa',4500);
            $table->string('riscoConsequencia',4500);
            $table->integer('nivel_de_risco');
            $table->string('riscoAno');
            $table->unsignedBigInteger('userIdRisco');
            $table->foreign('userIdRisco')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('unidadeId');
            $table->foreign('unidadeId')->references('id')->on('unidades')->onDelete('cascade');
            $table->timestamps();
            //Quando criado o campo unidade, referenciar a unidade aqui
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('riscos');
    }
};
