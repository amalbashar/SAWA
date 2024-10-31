<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\CareProviderProfile;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // إنشاء مستخدم "Admin"
        $adminUser = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role_id' => Role::where('name', 'Admin')->first()->id,
        ]);

        // إنشاء مستخدم "User" عادي
        $regularUser = User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role_id' => Role::where('name', 'User')->first()->id,
        ]);

        // إنشاء أول مقدم رعاية "Care Provider 1"
        $careProviderUser1 = User::create([
            'name' => 'Care Provider 1',
            'email' => 'careprovider1@example.com',
            'password' => Hash::make('password'),
            'role_id' => Role::where('name', 'CareProvider')->first()->id,
        ]);

        CareProviderProfile::create([
            'user_id' => $careProviderUser1->id, // ربط المستخدم بملف مقدم الرعاية
            'specialization' => 'General Practitioner',
            'bio' => 'Experienced general practitioner offering home services and clinic consultations.',
            'offers_home_services' => true,
            'clinic_address' => '123 Health St, City X',
        ]);

        // إنشاء مقدم رعاية ثاني "Care Provider 2"
        $careProviderUser2 = User::create([
            'name' => 'Care Provider 2',
            'email' => 'careprovider2@example.com',
            'password' => Hash::make('password'),
            'role_id' => Role::where('name', 'CareProvider')->first()->id,
        ]);

        CareProviderProfile::create([
            'user_id' => $careProviderUser2->id,
            'specialization' => 'Pediatrician',
            'bio' => 'Specialist in children’s health, providing expert care from infancy to adolescence.',
            'offers_home_services' => false,
            'clinic_address' => '456 Wellness Ave, City Y',
        ]);

        // إنشاء مقدم رعاية ثالث "Care Provider 3"
        $careProviderUser3 = User::create([
            'name' => 'Care Provider 3',
            'email' => 'careprovider3@example.com',
            'password' => Hash::make('password'),
            'role_id' => Role::where('name', 'CareProvider')->first()->id,
        ]);

        CareProviderProfile::create([
            'user_id' => $careProviderUser3->id,
            'specialization' => 'Mental Health Counselor',
            'bio' => 'Provides professional counseling services focusing on mental health and well-being.',
            'offers_home_services' => true,
            'clinic_address' => '789 Therapy Lane, City Z',
        ]);

        // إنشاء مقدم رعاية رابع "Care Provider 4"
        $careProviderUser4 = User::create([
            'name' => 'Care Provider 4',
            'email' => 'careprovider4@example.com',
            'password' => Hash::make('password'),
            'role_id' => Role::where('name', 'CareProvider')->first()->id,
        ]);

        CareProviderProfile::create([
            'user_id' => $careProviderUser4->id,
            'specialization' => 'Pediatrician',
            'bio' => 'Expert in skin health, offering treatments for various skin conditions.',
            'offers_home_services' => false,
            'clinic_address' => '101 Skin Care Blvd, City A',
        ]);

        // إنشاء مقدم رعاية خامس "Care Provider 5"
        $careProviderUser5 = User::create([
            'name' => 'Care Provider 5',
            'email' => 'careprovider5@example.com',
            'password' => Hash::make('password'),
            'role_id' => Role::where('name', 'CareProvider')->first()->id,
        ]);

        CareProviderProfile::create([
            'user_id' => $careProviderUser5->id,
            'specialization' => 'Physical Therapist',
            'bio' => 'Providing physical therapy services to aid in recovery and rehabilitation.',
            'offers_home_services' => true,
            'clinic_address' => '202 Recovery Road, City B',
        ]);

        // إنشاء مقدم رعاية سادس "Care Provider 6"
        $careProviderUser6 = User::create([
            'name' => 'Care Provider 6',
            'email' => 'careprovider6@example.com',
            'password' => Hash::make('password'),
            'role_id' => Role::where('name', 'CareProvider')->first()->id,
        ]);

        CareProviderProfile::create([
            'user_id' => $careProviderUser6->id,
            'specialization' => 'Psychiatrist',
            'bio' => 'Specializes in diet planning and nutrition for healthy living.',
            'offers_home_services' => true,
            'clinic_address' => '303 Health Way, City C',
        ]);

        // إنشاء مستخدم "Super Admin"
        $superAdminUser = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password'),
            'role_id' => Role::where('name', 'SuperAdmin')->first()->id,
        ]);
    }
}
