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
        Schema::create('monitoramentos', function (Blueprint $table) {
            $table->id();
            $table->string('monitoramentoControleSugerido');
            $table->string('statusMonitoramento');
            $table->string('execucaoMonitoramento');
            $table->unsignedBigInteger('riscoFK');
            $table->foreign('riscoFK')->references('id')->on('riscos')->onDelete('cascade');
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
        Schema::dropIfExists('monitoramentos');
    }
};
