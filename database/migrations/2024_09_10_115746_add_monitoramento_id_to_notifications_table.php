<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMonitoramentoIdToNotificationsTable extends Migration
{
    /**
     * Execute as alterações na tabela.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->unsignedBigInteger('monitoramentoId')->nullable();
            $table->foreign('monitoramentoId')->references('id')->on('monitoramentos')->onDelete('cascade');
        });
    }

    /**
     * Reverter as alterações na tabela.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropForeign(['monitoramentoId']);
            $table->dropColumn('monitoramentoId');
        });
    }
}
