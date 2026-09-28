<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
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
            $table->string('bienio', 9)->nullable(); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('plano_acoes'); // Corrigido de 'plano_acaos' para 'plano_acoes'
    }
};