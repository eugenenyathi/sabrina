<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $students = Student::select('student_id')->get();

        foreach ($students as $student) {
            $hasAccount = User::where('student_id', $student->student_id)->exists();

            if (!$hasAccount) {
                User::create([
                    'student_id' => $student->student_id,
                    'password' => Hash::make('12345678')
                ]);
            }
        }
    }
}
