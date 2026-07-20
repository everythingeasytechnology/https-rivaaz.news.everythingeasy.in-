<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mockCategories = [
            'politics' => [
                'name' => 'राजनीति',
                'subcategories' => []
            ],
            'sports' => [
                'name' => 'खेल',
                'subcategories' => []
            ],
            'technology' => [
                'name' => 'तकनीकी',
                'subcategories' => [
                    'स्मार्टफोन व गैजेट्स',
                    'आर्टिफिशियल इंटेलिजेंस'
                ]
            ],
        ];

        foreach ($mockCategories as $slug => $data) {
            $parent = Category::create([
                'name' => $data['name'],
                'slug' => $slug,
                'parent_id' => null,
                'meta_title' => $data['name'] . ' समाचार - रीवाज़ क्रॉनिकल',
                'meta_description' => $data['name'] . ' से संबंधित नवीनतम समाचार और मुख्य अपडेट्स।',
                'meta_keywords' => strtolower($data['name']) . ', news, updates'
            ]);

            foreach ($data['subcategories'] as $sub) {
                // Ensure slug is clean and unique for subcategories
                $subSlug = Str::slug($sub);
                Category::create([
                    'name' => $sub,
                    'slug' => $subSlug,
                    'parent_id' => $parent->id,
                    'meta_title' => $sub . ' - ' . $data['name'] . ' समाचार - रीवाज़ क्रॉनिकल',
                    'meta_description' => $sub . ' पर वास्तविक समय की रिपोर्टिंग और गहन विश्लेषण।',
                    'meta_keywords' => strtolower($sub) . ', ' . strtolower($data['name']) . ', news'
                ]);
            }
        }
    }
}
