<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MediasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed SK Mediator based on joomla-orig/mediasi.html
        DB::table('mediasi_sk')->insert([
            [
                'tahun' => 2024,
                'link_sk_hakim' => 'https://drive.google.com/file/d/1lFthNqFDHRvQvCl8TmREOeLr5QdN3DzA/preview',
                'link_sk_non_hakim' => 'https://drive.google.com/file/d/1j7wCkS-LiuNo8CJNzQgtzLpYvCcqtbrB/preview',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'tahun' => 2023,
                'link_sk_hakim' => 'https://drive.google.com/file/d/1oBpe1hpOMNHj5KfCwmScjF1EfqEXlZ9N/preview',
                'link_sk_non_hakim' => 'https://www.pa-penajam.go.id/images/PDF/suratkeputusan/SK_MEDIATOR_NON_HAKIM_2023.pdf',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'tahun' => 2022,
                'link_sk_hakim' => 'https://drive.google.com/file/d/1TqkbLshowbPRzaMh-MyVr8clCo_Nc3ZN/preview',
                'link_sk_non_hakim' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ]);

        // Seed Mediator Banners based on joomla-orig/mediasi.html
        DB::table('mediator_banners')->insert([
            [
                'judul' => 'Daftar Mediator Non-Hakim',
                'image_url' => 'https://www.pa-penajam.go.id/images/Mediator_Non_Hakimm.jpg',
                'type' => 'non-hakim',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'judul' => 'Daftar Mediator Hakim',
                'image_url' => 'https://www.pa-penajam.go.id/images/DAFTAR_MEDIATOR_HAKIM_200_x_200_piksel_600_x_400_piksel_800_x_500_piksel_1.png',
                'type' => 'hakim',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ]);
    }
}
