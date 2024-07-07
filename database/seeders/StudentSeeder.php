<?php

namespace Database\Seeders;

use App\Constants\StudentConstants;
use App\Traits\Utils;
use App\Traits\SQLite;
use App\Models\Student;
use App\Traits\FakeCredentials;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StudentSeeder extends Seeder
{
    use FakeCredentials;
    use SQLite;
    use Utils;

    public function run(): void
    {
        $this->seed(StudentConstants::FEMALE, 120);
        $this->seed(StudentConstants::MALE, 80);
    }

    private function seed($gender, $numberToSeed)
    {
        $names = $this->getNames($gender);

        for ($i = 0; $i < $numberToSeed; $i++) {
            $fullName = $this->createFakeName($names);

            Student::create([
                "student_id" => $this->fakeStudentID(),
                "fullName" => $fullName,
                "dob" => $this->fakeDob(1999, 2005),
                "national_id" => $this->fakeNationalID(),
                "gender" => $gender
            ]);
        }
    }
}
