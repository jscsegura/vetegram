<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class LanguagesSeeder extends Seeder
{
    /**
     * Seed the languages table with common languages (Americas + major global).
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        $languages = [
            ['en' => 'English', 'es' => 'Inglés'],
            ['en' => 'Spanish', 'es' => 'Español'],
            ['en' => 'Portuguese', 'es' => 'Portugués'],
            ['en' => 'French', 'es' => 'Francés'],
            ['en' => 'Dutch', 'es' => 'Neerlandés'],
            ['en' => 'Haitian Creole', 'es' => 'Criollo haitiano'],
            ['en' => 'Papiamento', 'es' => 'Papiamento'],
            ['en' => 'Guarani', 'es' => 'Guaraní'],
            ['en' => 'Quechua', 'es' => 'Quechua'],
            ['en' => 'Aymara', 'es' => 'Aymara'],
            ['en' => 'Nahuatl', 'es' => 'Náhuatl'],
            ['en' => 'Yucatec Maya', 'es' => 'Maya yucateco'],
            ['en' => 'Mapudungun', 'es' => 'Mapudungun'],
            ['en' => 'German', 'es' => 'Alemán'],
            ['en' => 'Italian', 'es' => 'Italiano'],
            ['en' => 'Russian', 'es' => 'Ruso'],
            ['en' => 'Arabic', 'es' => 'Árabe'],
            ['en' => 'Mandarin Chinese', 'es' => 'Chino mandarín'],
            ['en' => 'Japanese', 'es' => 'Japonés'],
            ['en' => 'Korean', 'es' => 'Coreano'],
            ['en' => 'Hindi', 'es' => 'Hindi'],
            ['en' => 'Bengali', 'es' => 'Bengalí'],
            ['en' => 'Punjabi', 'es' => 'Punyabí'],
            ['en' => 'Urdu', 'es' => 'Urdu'],
            ['en' => 'Turkish', 'es' => 'Turco'],
            ['en' => 'Vietnamese', 'es' => 'Vietnamita'],
            ['en' => 'Thai', 'es' => 'Tailandés'],
            ['en' => 'Polish', 'es' => 'Polaco'],
            ['en' => 'Ukrainian', 'es' => 'Ucraniano'],
            ['en' => 'Greek', 'es' => 'Griego'],
            ['en' => 'Hebrew', 'es' => 'Hebreo'],
            ['en' => 'Persian', 'es' => 'Persa'],
            ['en' => 'Swahili', 'es' => 'Suajili'],
            ['en' => 'Afrikaans', 'es' => 'Afrikáans'],
            ['en' => 'Czech', 'es' => 'Checo'],
            ['en' => 'Romanian', 'es' => 'Rumano'],
            ['en' => 'Hungarian', 'es' => 'Húngaro'],
            ['en' => 'Swedish', 'es' => 'Sueco'],
            ['en' => 'Norwegian', 'es' => 'Noruego'],
            ['en' => 'Danish', 'es' => 'Danés'],
            ['en' => 'Finnish', 'es' => 'Finés'],
            ['en' => 'Filipino', 'es' => 'Filipino'],
            ['en' => 'Indonesian', 'es' => 'Indonesio'],
            ['en' => 'Malay', 'es' => 'Malayo'],
            ['en' => 'Basque', 'es' => 'Euskera'],
            ['en' => 'Catalan', 'es' => 'Catalán'],
            ['en' => 'Galician', 'es' => 'Gallego'],
        ];

        foreach ($languages as $language) {
            DB::table('languages')->updateOrInsert(
                [
                    'title_en' => $language['en'],
                    'title_es' => $language['es'],
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
