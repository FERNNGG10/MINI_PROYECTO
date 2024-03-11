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
        Schema::create('game_inventory',function(Blueprint $table){

            $table->id();
            $table->foreignId('game_id')
            ->constrained('games')
            ->onDelete('cascade');
            $table->integer('stock');
            $table->decimal('price', 8, 2);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_inventory');

    }
};
