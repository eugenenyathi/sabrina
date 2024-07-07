<?php

namespace Database\Seeders;

use App\Constants\ProgramConstants;
use App\Models\Program;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        foreach (ProgramConstants::PROGRAMS as $program) {
            if (Program::where('program_id', $program['program_id'])->exists()) continue;
            else {
                Program::create([
                    'program_id' => $program['program_id'],
                    'program' => $program['program'],
                    'faculty_id' => $program['faculty_id']
                ]);
            }
        }
    }
}
