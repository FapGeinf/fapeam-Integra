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
        Schema::table('atividades', function (Blueprint $table) {
              $table->unsignedBigInteger('status_atividade_id')->nullable()->after('id');
              $table->foreign('status_atividade_id')->references('id')->on('status_atividades')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('atividades', function (Blueprint $table) {
              $table->dropForeign(['status_atividade_id']);
              $table->dropColumn('status_atividade_id');
        });
    }
};
