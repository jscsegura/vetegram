<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SpecialtiesSeeder extends Seeder
{
    /**
     * Seed the specialties table with curated medical specialties.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        $specialties = [
            ['en' => 'General Practice', 'es' => 'Medicina general'],
            ['en' => 'Preventive Care', 'es' => 'Medicina preventiva'],
            ['en' => 'Vaccination & Wellness', 'es' => 'Vacunación y bienestar'],
            ['en' => 'Internal Medicine', 'es' => 'Medicina interna'],
            ['en' => 'Surgery (General)', 'es' => 'Cirugía general'],
            ['en' => 'Dentistry', 'es' => 'Odontología'],
            ['en' => 'Emergency & Urgent Care', 'es' => 'Emergencias y urgencias'],
            ['en' => 'Dermatology', 'es' => 'Dermatología'],
            ['en' => 'Cardiology', 'es' => 'Cardiología'],
            ['en' => 'Neurology', 'es' => 'Neurología'],
            ['en' => 'Oncology', 'es' => 'Oncología'],
            ['en' => 'Ophthalmology', 'es' => 'Oftalmología'],
            ['en' => 'Orthopedics', 'es' => 'Ortopedia'],
            ['en' => 'Anesthesiology', 'es' => 'Anestesiología'],
            ['en' => 'Radiology/Diagnostic Imaging', 'es' => 'Radiología/Imagen diagnóstica'],
            ['en' => 'Rehabilitation & Physical Therapy', 'es' => 'Rehabilitación y fisioterapia'],
            ['en' => 'Pain Management', 'es' => 'Manejo del dolor'],
            ['en' => 'Laboratory Diagnostics', 'es' => 'Diagnóstico de laboratorio'],
            ['en' => 'Ultrasound', 'es' => 'Ultrasonido'],
            ['en' => 'X-Ray', 'es' => 'Rayos X'],
            ['en' => 'Endoscopy', 'es' => 'Endoscopía'],
            ['en' => 'Pathology', 'es' => 'Patología'],
            ['en' => 'Behavioral Medicine', 'es' => 'Medicina del comportamiento'],
            ['en' => 'Nutrition', 'es' => 'Nutrición'],
            ['en' => 'Integrative Medicine', 'es' => 'Medicina integrativa'],
            ['en' => 'Acupuncture', 'es' => 'Acupuntura'],
            ['en' => 'Chiropractic Care', 'es' => 'Quiropráctica'],
        ];

        foreach ($specialties as $item) {
            DB::table('specialties')->updateOrInsert(
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
