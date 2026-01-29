<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class SpeciesSeeder extends Seeder
{
    /**
     * Seed the species table with common species groups.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        $species = [
            ['en' => 'Dogs & Cats', 'es' => 'Perros y gatos'],
            ['en' => 'Exotic Animals', 'es' => 'Animales exóticos'],
            ['en' => 'Avian', 'es' => 'Aves'],
            ['en' => 'Equine', 'es' => 'Equinos'],
            ['en' => 'Farm / Production Animals', 'es' => 'Animales de producción'],
            ['en' => 'Wildlife', 'es' => 'Vida silvestre'],
        ];

        foreach ($species as $item) {
            DB::table('species')->updateOrInsert(
                [
                    'title_en' => $item['en'],
                    'title_es' => $item['es'],
                ],
                [
                    'enabled' => 1,
                    'updated_at' => $now,
                    'created_at' => $now,
                ]
            );
        }
    }
}
