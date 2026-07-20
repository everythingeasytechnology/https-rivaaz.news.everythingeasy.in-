<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Super Admin
        User::create([
            'name' => 'मुख्य संपादक',
            'email' => 'admin@news.com',
            'password' => bcrypt('admin123'),
            'role' => 'super_admin',
        ]);

        // 2. Seed Editors (Mock Authors)
        $editors = [
            ['name' => 'Rajesh Sharma', 'email' => 'rajesh@news.com'],
            ['name' => 'Ananya Sen', 'email' => 'ananya@news.com'],
            ['name' => 'Vikram Malhotra', 'email' => 'vikram@news.com'],
            ['name' => 'Priya Gopal', 'email' => 'priya@news.com'],
        ];

        foreach ($editors as $editor) {
            User::create([
                'name' => $editor['name'],
                'email' => $editor['email'],
                'password' => bcrypt('editor123'),
                'role' => 'editor',
            ]);
        }

        // 3. Seed Category Table
        $this->call(CategorySeeder::class);

        // 4. Seed Settings Table
        $this->call(SettingSeeder::class);

        // 5. Seed Articles Table
        $this->call(ArticleSeeder::class);
    }
}
