<?php

namespace Database\Seeders;

use App\Constants\FacultyConstants;
use App\Models\Faculty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (FacultyConstants::FACULTIES as $faculty) {
            if (Faculty::where('faculty_id', $faculty['faculty_id'])->exists()) continue;
            else {
                Faculty::create([
                    'faculty_id' => $faculty['faculty_id'],
                    'faculty' => $faculty['faculty_name']
                ]);
            }
        }
    }
}
