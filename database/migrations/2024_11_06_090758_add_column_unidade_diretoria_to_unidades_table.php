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
        Schema::table('unidades', function (Blueprint $table) {
              $table->unsignedBigInteger('unidadeDiretoria')->nullable();
              $table->foreign('unidadeDiretoria')->references('id')->on('diretorias')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('unidades', function (Blueprint $table) {
               $table->dropForeign(['unidadeDiretoria']);
               $table->dropColumn('unidadeDiretoria');
        });
    }
};
