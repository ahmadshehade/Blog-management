<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("categories")->delete();

        $categories = [
            [

                'name' => 'Technology',
                'slug' => Str::slug('Technology'),
                'description' => 'Latest news and articles on technology.',
                'parent_id' => null,
                'is_active' => true
            ],
            [

                'name' => 'Health',
                'slug' => Str::slug('Health'),
                'description' => 'Articles about health and nutrition.',
                'parent_id' => null,
                'is_active' => true
            ],
            [
                
                'name' => 'Sports',
                'slug' => Str::slug('Sports'),
                'description' => 'Sports news and analysis.',
                'parent_id' => null,
                'is_active' => true
            ],
        ];

        foreach($categories as $category){
             Category::create($category);
        }
    }
}