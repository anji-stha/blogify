<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tag::create(['name' => 'art', 'slug' => 'art']);
        Tag::create(['name' => 'food', 'slug' => 'food']);
        Tag::create(['name' => 'nature', 'slug' => 'nature']);
    }
}
