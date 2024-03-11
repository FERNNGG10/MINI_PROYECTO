<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories =[
            ['name' =>  "Action"],
            ['name' =>  "Adventure"],
            ['name' =>  "RPG"],
            ['name' =>  "Simulation"],
            ['name' =>  "Strategy"],
            ['name' =>  "Sports"],
            ['name' =>  "Puzzle"],
            ['name' =>  "Idle"],
            ['name' =>  "Casual"],
            ['name' =>  "Arcade"],
            ['name' =>  "Racing"],
            ['name' =>  "Horror"],
            ['name' =>  "Survival"],
            ['name' =>  "Shooter"],
            ['name' =>  "Fighting"],
            ['name' =>  "Open World"],
            ['name' =>  "Sandbox"],
            ['name' =>  "Battle Royale"],
            ['name' =>  "Trivia"],
        ];

        DB::table('categories')->insert($categories);
    }
}
