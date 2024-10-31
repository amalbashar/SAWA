<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CareProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('care_provider_profiles')->insert([
            [
                'user_id' => 1,
                'specialization' => 'Dietitian',
                'bio' => 'A highly experienced neurologist offering a wide range of medical services.',
                'offers_home_services' => true,
                'clinic_address' => '123 Health St, City X',
                'price' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'specialization' => 'Neurologist', // استخدام تخصص متوافق مع enum
                'bio' => 'Specializes in diet and nutrition, providing expert care.',
                'offers_home_services' => false,
                'clinic_address' => '456 Wellness Ave, City Y',
                'price' => 120,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'specialization' => 'Pediatrician', // استخدام تخصص متوافق مع enum
                'bio' => 'Provides professional counseling services focusing on mental health and well-being.',
                'offers_home_services' => true,
                'clinic_address' => '789 Therapy Lane, City Z',
                'price' => 150,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);


    }
}
