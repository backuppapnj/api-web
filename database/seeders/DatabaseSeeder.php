<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PanggilanSeeder::class,
            ItsbatSeeder::class,
            PanggilanEcourtSeeder::class,
            LhkpnSeeder::class,
            AnggaranSeeder::class,
            DipaPokSeeder::class,
            AsetBmnSeeder::class,
        ]);
    }
}
