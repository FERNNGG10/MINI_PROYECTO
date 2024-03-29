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
        Schema::create('supplier_games',function(Blueprint $table){

            $table->id();
            $table->foreignId('supplier_id')
            ->constrained('suppliers')
            ->onDelete('cascade');
            $table->foreignId('game_id')
            ->constrained('games')
            ->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supplier_games');

    }
};
