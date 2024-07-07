<?php

namespace Database\Seeders;

use App\Constants\SrcPostConstants;
use App\Models\SrcPost;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SrcPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (SrcPostConstants::POSTS as $srcPost) {
            SrcPost::create($srcPost);
        }
    }
}
