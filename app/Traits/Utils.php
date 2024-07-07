<?php

namespace App\Traits;

use App\Models\Profile;
use App\Models\Student;
use App\Models\Tuition;
use App\Models\CheckInOut;
use App\Models\LoginTimestamps;
use App\Models\SearchException;
use Illuminate\Support\Facades\DB;
use App\Constants\FacultyConstants;
use App\Constants\StudentConstants;
use App\Models\SrcPost;

trait Utils
{


    protected function faculty($studentID)
    {
        $faculty = DB::table('profiles')
            ->where('student_id', $studentID)
            ->join('programs', 'profiles.program_id', '=', 'programs.program_id')
            ->join('faculties', 'programs.faculty_id', '=', 'faculties.faculty_id')
            ->select('faculties.faculty')
            ->first();


        return $faculty->faculty;
    }

    protected function facultyID($studentID)
    {
        $faculty = DB::table('profiles')
            ->where('student_id', $studentID)
            ->join('programs', 'profiles.program_id', '=', 'programs.program_id')
            ->select('programs.faculty_id')
            ->first();


        return $faculty->faculty_id;
    }

    protected function facultyTuition($studentID)
    {
        //get what type of student is it
        $studentType = $this->studentType($studentID);

        if ($studentType === StudentConstants::CON_STUDENT) $tuitionColumn = 'con_amount';
        else $tuitionColumn = 'block_amount';

        $tuition = DB::table('profiles')
            ->where('profiles.student_id', $studentID)
            ->join('programs', 'profiles.program_id', '=', 'programs.program_id')
            ->join('tuition', 'programs.faculty_id', '=', 'tuition.faculty_id')
            ->select($tuitionColumn)
            ->first();

        return $tuition->$tuitionColumn;
        // return $tuition;
    }

    protected function program($studentID)
    {
        $program = DB::table('profiles')
            ->where('profiles.student_id', $studentID)
            ->join('programs', 'profiles.program_id', '=', 'programs.program_id')
            ->select('programs.program')
            ->first();

        return $program->program;
    }

    protected function programID($studentID)
    {
        $program = Profile::select('program_id')->where('student_id', $studentID)->first();

        return $program->program_id;
    }


    protected function studentType($studentID)
    {
        $profile = Profile::select('student_type')->where('student_id', $studentID)->first();

        return $profile->student_type;
    }

    public function part($studentID)
    {
        $profile = Profile::select('part')->where('student_id', $studentID)->first();

        return $profile->part;
    }


    public function previousPart($studentID)
    {
        $levels = [1.1, 1.2, 2.1, 2.2, 4.1, 4.2];
        //fetch student level
        $student = Profile::select('part')->where('student_id', $studentID)->first();
        $indexOfCurrentLevel = array_search($student->part, $levels);
        $previousLevel = $levels[$indexOfCurrentLevel - 1];

        return $previousLevel;
    }

    public function gender($studentID)
    {
        $student = Student::select('gender')->where('student_id', $studentID)->first();
        return $student->gender;
    }


    protected function random($firstIndex, $lastIndex)
    {
        return mt_rand($firstIndex, $lastIndex);
    }

    public function studentProfile($studentID)
    {
        $student = DB::table('students')
            ->join('profiles', 'students.student_id', '=', 'profiles.student_id')
            ->select([
                'students.fullName', 'students.gender',
                'profiles.student_type', 'profiles.part', 'profiles.enrolled'
            ])
            ->where('students.student_id', $studentID)
            ->first();

        $data = [
            'studentNumber' => $studentID,
            'name' => $student->fullName,
            'gender' => $student->gender,
            'faculty' => $this->faculty($studentID),
            'program' => $this->program($studentID),
            'studentType' => $student->student_type,
            'part' => $student->part,
            'enrolled' => $student->enrolled,
        ];

        // return $this->sendData($data);
        return $data;
    }

    public function getSRCPost($src_post_id)
    {
        $src_post = SrcPost::select('post')->where('src_post_id', $src_post_id)->first();
        return $src_post->post;
    }

    public function getFullName($studentID)
    {
        $student = Student::select('fullName')->where('student_id', $studentID)->first();

        return $student;
    }
}
