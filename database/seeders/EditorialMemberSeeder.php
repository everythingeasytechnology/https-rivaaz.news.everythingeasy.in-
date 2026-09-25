<?php

namespace Database\Seeders;

use App\Models\EditorialMember;
use Illuminate\Database\Seeder;

class EditorialMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (EditorialMember::count() === 0) {
            EditorialMember::create([
                'name' => 'Rajesh Sharma',
                'designation' => 'Chief Political Director',
                'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=150&q=80',
                'bio' => 'Senior journalist overseeing political bureaus and investigative stories.',
                'sort_order' => 1,
                'is_active' => true,
            ]);

            EditorialMember::create([
                'name' => 'Ananya Sen',
                'designation' => 'Technology Desk Lead',
                'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=150&q=80',
                'bio' => 'Specializes in tech analysis, cybersecurity developments, and innovation reporting.',
                'sort_order' => 2,
                'is_active' => true,
            ]);

            EditorialMember::create([
                'name' => 'Vikram Malhotra',
                'designation' => 'Editor-in-Chief (Finance)',
                'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=150&q=80',
                'bio' => 'Veteran economic editor analyzing markets, budgets, and national monetary policy.',
                'sort_order' => 3,
                'is_active' => true,
            ]);
        }
    }
}
