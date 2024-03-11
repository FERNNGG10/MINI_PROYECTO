<?php

namespace Database\Seeders;

use App\Models\Console;
use App\Models\Console_Inventory;
use App\Models\Supplier_Console;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConsoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $console = Console::create([
            'name' => 'Console',
            'maker' => 'Maker',
             
        ]);

        Console_Inventory::create([
            'console_id' => $console->id,
            'stock' => 10,
            'price' => 2000
        ]);

       
        Supplier_Console::create([
            'console_id' => $console->id,
            'supplier_id' => 1
        ]);
    }
}
