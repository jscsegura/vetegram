<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ClinicServicesSeeder extends Seeder
{
    /**
     * Seed the clinic_services table with common services.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        $services = [
            ['en' => 'Emergency Care', 'es' => 'Emergencias'],
            ['en' => '24/7 Clinic', 'es' => 'Clínica 24/7'],
            ['en' => 'Referral Center', 'es' => 'Centro de referencia'],
            ['en' => 'Mobile Veterinary Services', 'es' => 'Servicios veterinarios móviles'],
            ['en' => 'Telemedicine', 'es' => 'Telemedicina'],
            ['en' => 'Home Visits', 'es' => 'Visitas a domicilio'],
            ['en' => 'Fear-Free Certified', 'es' => 'Certificación Fear-Free'],
        ];

        foreach ($services as $item) {
            DB::table('clinic_services')->updateOrInsert(
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
