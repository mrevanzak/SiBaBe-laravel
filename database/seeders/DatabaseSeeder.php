<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Admin;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Admin::create([
            'username' => 'admin',
            'name' => 'admin',
            'password' => bcrypt('admin'),
            'email' => 'admin@sibabe.app',
            'phone' => '081234567890',
        ]);
    }
}
