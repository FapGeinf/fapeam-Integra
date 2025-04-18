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
				Schema::create('atividade_indicadores', function (Blueprint $table) {
						$table->id();
						$table->foreignId('atividade_id')->constrained()->onDelete('cascade');
						$table->foreignId('indicador_id')->constrained('indicadores')->onDelete('cascade');
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
        Schema::dropIfExists('atividade_indicadores');
    }
};
