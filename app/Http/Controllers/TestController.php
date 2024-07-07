<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Traits\FakeCredentials;
use App\Models\CandidateProfile;
use Illuminate\Support\Facades\DB;
use App\Constants\CandidateProfileConstants;

class TestController extends Controller
{
    use FakeCredentials;
    use HttpResponses;

    public function init()
    {
        $srcPostId = 'PRES';

        $data = DB::table('student_council')
            ->join('students', 'student_council.student_id', 'students.student_id')
            ->join('src_posts', 'student_council.src_post_id', 'src_posts.src_post_id')
            ->join('profiles', 'student_council.student_id', 'profiles.student_id')
            ->join('programs', 'profiles.program_id', 'programs.program_id')
            ->select(
                'students.fullName',
                'students.student_id',
                'programs.program',
                'profiles.part',
                'src_posts.src_post_id',
                'src_posts.post',
                'student_council.profile_url',
                'student_council.contact',
            )
            ->get();

        return $this->sendData($data);
    }
}
