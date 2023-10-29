<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 100; $i++) {
            $title = fake()->words(8, true);

            News::create([
                "title" => $title,
                "slug" => Str::slug($title . Str::random(16)),
                "content" => fake()->sentence(100),
                "user_id" => 1
            ]);
        }
    }
}
