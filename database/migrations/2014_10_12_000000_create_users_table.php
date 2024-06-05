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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();//a ser removido que a auth tiver pronta
						$table->string('cpf')->unique();
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
						$table->unsignedBigInteger('userTipoFk');
						$table->foreign('userTipoFk')->references('id')->on('user_tipos');
						$table->bigInteger('unidadeIdFK')->unsigned();
						$table->foreign('unidadeIdFK')->references('id')->on('unidades');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
