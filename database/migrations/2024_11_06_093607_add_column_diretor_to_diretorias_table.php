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
        Schema::table('diretorias', function (Blueprint $table) {
              $table->unsignedBigInteger('diretor')->nullable();
              $table->foreign('diretor')->references('id')->on('users')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('diretorias', function (Blueprint $table) {
               $table->dropForeign(['diretor']);
               $table->dropColumn('diretor');
        });
    }
};
