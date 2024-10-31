<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('events')->insert([
            [
                'care_provider_id' => 1, // تأكد أن لديك id مطابق في جدول care_provider_profiles
                'title' => 'Health Awareness Workshop',
                'description' => 'A workshop on raising awareness about health and wellness.',
                'date' => Carbon::now()->addDays(10),
                'location' => 'Community Center, City X',
                'capacity' => 100,
                'image' => 'images/events/event-01.jpg',
                'short_description' => 'A brief health awareness session for community members.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'care_provider_id' => 2, // تأكد أن لديك id مطابق في جدول care_provider_profiles
                'title' => 'Mental Health Counseling Event',
                'description' => 'An event focused on providing counseling for mental health issues.',
                'date' => Carbon::now()->addDays(20),
                'location' => 'Mental Health Clinic, City Y',
                'capacity' => 50,
                'image' => 'images/events/event-02.jpg',
                'short_description' => 'A counseling event focused on mental health.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'care_provider_id' => 2, // تأكد أن لديك id مطابق في جدول care_provider_profiles
                'title' => 'Mental Health Counseling Event',
                'description' => 'An event focused on providing counseling for mental health issues.',
                'date' => Carbon::now()->addDays(5),
                'location' => 'Mental Health Clinic, City Y',
                'capacity' => 50,
                'image' => 'images/events/event-02.jpg',
                'short_description' => 'A counseling event focused on mental health.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'care_provider_id' => 2, // تأكد أن لديك id مطابق في جدول care_provider_profiles
                'title' => 'Mental Health Counseling Event',
                'description' => 'An event focused on providing counseling for mental health issues.',
                'date' => Carbon::now()->addDays(30),
                'location' => 'Mental Health Clinic, City Y',
                'capacity' => 50,
                'image' => 'images/events/event-02.jpg',
                'short_description' => 'A counseling event focused on mental health.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'care_provider_id' => 2, // تأكد أن لديك id مطابق في جدول care_provider_profiles
                'title' => 'Mental Health Counseling Event',
                'description' => 'An event focused on providing counseling for mental health issues.',
                'date' => Carbon::now()->addDays(45),
                'location' => 'Mental Health Clinic, City Y',
                'capacity' => 50,
                'image' => 'images/events/event-02.jpg',
                'short_description' => 'A counseling event focused on mental health.',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
