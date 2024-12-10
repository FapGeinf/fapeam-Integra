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
        Schema::table('users', function (Blueprint $table) {
              $table->unsignedBigInteger('usuario_tipo_fk')->nullable();
              $table->foreign('usuario_tipo_fk')->references('id')->on('usuario_tipos')->onUpdate('set null')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
               $table->dropForeign(['usuario_tipo_fk']);
               $table->dropColumn('usuario_tipo_fk');
        });
    }
};
