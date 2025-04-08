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
        Schema::create('atividade_canal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('atividade_id');
            $table->unsignedBigInteger('canal_id');
            $table->foreign('atividade_id')->references('id')->on('atividades')->onDelete('cascade');
            $table->foreign('canal_id')->references('id')->on('canais')->onDelete('cascade');
            
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
        Schema::dropIfExists('atividade_canal');
    }
};
