<?php

namespace App\Http\Services;

use App\Models\Candidate;
use App\Models\PortalStatus;
use App\Models\CandidateProfile;
use Illuminate\Support\Facades\DB;
use App\Constants\PortalStatusConstants;

class CandidateService
{
    public function getCandidateSrcPostId($candidateStudentId)
    {
        return Candidate::select('src_post_id')->where('student_id', $candidateStudentId)->first();
    }

    public function getCandidatesBySrcPostId($srcPostId)
    {
        return Candidate::select('student_id')->where('src_post_id', $srcPostId)->get();
    }

    public function createCandidate($applicantId, $applicantSrcPostId)
    {
        Candidate::create([
            'student_id' => $applicantId,
            'src_post_id' => $applicantSrcPostId
        ]);
    }

    public function getCandidateProfileUrl($candidateStudentId)
    {
        return CandidateProfile::select('profile_url')->where('student_id', $candidateStudentId)->first();
    }

    public function isStudentACandidate($studentId)
    {
        return Candidate::where('student_id', $studentId)->exists();
    }

    public function getCandidatesDeep($srcPostId)
    {
        return DB::table('candidates')
            ->where('candidates.src_post_id', $srcPostId)
            ->join('students', 'candidates.student_id', '=', 'students.student_id')
            ->join('profiles', 'candidates.student_id', '=', 'profiles.student_id')
            ->join('programs', 'profiles.program_id', '=', 'programs.program_id')
            ->join('candidate_profiles', 'candidates.student_id', '=', 'candidate_profiles.student_id')
            ->join('votes_count', 'candidates.student_id', '=', 'votes_count.candidate_id')
            ->select(
                'students.fullName',
                'students.student_id',
                'programs.program',
                'profiles.part',
                'candidates.src_post_id',
                'candidate_profiles.profile_url',
                'candidate_profiles.catch_phrase',
                'votes_count.votes'
            )
            ->orderBy('votes_count.votes', 'desc')
            ->get();
    }

    public function setAllPortalStatusesToInActive()
    {
        //Set all active portal status to NO 
        DB::table('portal_status')
            ->update([
                'active' => PortalStatusConstants::INACTIVE
            ]);
    }

    public function setPortalStatusToCandidateOnboarding()
    {
        PortalStatus::where('status', PortalStatusConstants::CANDIDATE_ONBOARDING)
            ->update(['active' => PortalStatusConstants::ACTIVE]);
    }
}
