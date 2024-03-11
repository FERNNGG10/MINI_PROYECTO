<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $suppliers = [
            ['name' => 'Sony','email' => 'sonyentertaiment@gmail.com','phone' => '8712382099'],
            ['name' => 'Xbox', 'email' => 'xbox@gmail.com', 'phone' => '9876543210'],
            ['name' => 'Nintendo', 'email' => 'nintendo@gmail.com', 'phone' => '1234567832'],
            ['name' => 'Microsoft', 'email' => 'microsoft@gmail.com', 'phone' => '8765432157'],
            ['name' => 'Ubisoft', 'email' => 'ubisoft@gmail.com', 'phone' => '9876543210'],
            ['name' => 'Electronic Arts', 'email' => 'ea@gmail.com', 'phone' => '1234567890'],
            ['name' => 'Activision', 'email' => 'activision@gmail.com', 'phone' => '9876543210'],
            ['name' => 'Square Enix', 'email' => 'squareenix@gmail.com', 'phone' => '1234567890'],
            ['name' => 'Capcom', 'email' => 'capcom@gmail.com', 'phone' => '9876543210']
        ];
        DB::table('suppliers')->insert($suppliers);
    }
}
