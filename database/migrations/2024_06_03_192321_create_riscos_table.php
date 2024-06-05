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
            $table->string('riscoEvento');
            $table->string('riscoCausa');
            $table->string('riscoConsequencia');
            $table->integer('riscoAvaliacao');
            $table->unsignedBigInteger('unidadeRiscoFK');
            $table->foreign('unidadeRiscoFk')->references('id')->on('unidades');
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
