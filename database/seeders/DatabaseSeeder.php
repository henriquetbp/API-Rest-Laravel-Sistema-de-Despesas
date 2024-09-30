<?php

namespace Database\Seeders;

use App\Models\Expense;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::factory()->create([
            'name' => 'Test User 2',
            'email' => 'user2@example.com',
        ]);

        Expense::factory(10)->create([
            'user_id' => 1,
        ]);

        Expense::factory(5)->create([
            'user_id' => 2,
        ]);
    }
}
