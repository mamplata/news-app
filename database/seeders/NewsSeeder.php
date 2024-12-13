<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NewsSeeder extends Seeder
{
    public function run()
    {
        // Assuming the user with ID 1 exists (created by UserSeeder)
        $userId = 1;

        // Create news entries using the DB facade
        DB::table('news')->insert([
            'headline' => 'Breaking News: Laravel 11 Released',
            'content' => 'Laravel 11 introduces new features and improvements...',
            'author' => 'Admin User',
            'date_published' => Carbon::now()->toDateString(), // Current date
            'user_id' => $userId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('news')->insert([
            'headline' => 'New Laravel Features to Try',
            'content' => 'In this article, we explore new features in Laravel...',
            'author' => 'Admin User',
            'date_published' => Carbon::now()->subDays(2)->toDateString(), // 2 days ago
            'user_id' => $userId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
