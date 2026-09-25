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
        Schema::create('plano_acoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('eixo_id')->constrained('eixos')->onDelete('cascade');
            $table->foreignId('responsavel_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('indicador_id')->nullable()->constrained('indicadores')->onDelete('set null');
            $table->text('objetivo');
            $table->text('descricao_acao');
            $table->decimal('meta', 10, 2)->nullable();
            $table->text('procedimentos')->nullable();
            $table->text('metricas')->nullable();
            $table->date('prazo_execucao')->nullable();
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
        Schema::dropIfExists('plano_acaos');
    }
};