<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Game_Inventory;
use App\Models\Supplier_Game;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GamesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $game = Game::create([
            'name' => 'Game',
            'maker' => 'Maker',
            'category_id' => 1, 
        ]);

        Game_Inventory::create([
            'game_id' => $game->id,
            'stock' => 10,
            'price' => 2000
        ]);

       
        Supplier_Game::create([
            'game_id' => $game->id,
            'supplier_id' => 1
        ]);
    }
}
