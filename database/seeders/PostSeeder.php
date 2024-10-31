<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('posts')->insert([
            [
                'user_id' => 1,
                'content' => 'This is the first post content for user 1.',
                'image' => 'images/post1.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'content' => 'Here is another interesting post for user 2.',
                'image' => 'images/post2.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'content' => 'User 3 sharing their thoughts here!',
                'image' => 'images/post3.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'content' => 'Another post from user 1 about their day.',
                'image' => 'images/post4.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
