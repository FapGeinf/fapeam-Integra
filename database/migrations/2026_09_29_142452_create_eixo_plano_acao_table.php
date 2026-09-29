<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        
        Schema::create('eixo_plano_acao', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plano_acao_id')->constrained('plano_acoes')->onDelete('cascade');
            $table->foreignId('eixo_id')->constrained('eixos')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['plano_acao_id', 'eixo_id']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eixo_plano_acao');
    }
};