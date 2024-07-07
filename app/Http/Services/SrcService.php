<?php

namespace App\Http\Services;

use App\Models\PortalStatus;
use App\Models\StudentCouncil;
use App\Models\CandidateProfile;
use Illuminate\Support\Facades\DB;
use App\Constants\PortalStatusConstants;
use App\Constants\SrcPostConstants;

class SrcService
{
    public function getSRCMembers()
    {
        return DB::table('student_council')
            ->join('students', 'student_council.student_id', '=', 'students.student_id')
            ->join('src_posts', 'student_council.src_post_id', '=', 'src_posts.src_post_id')
            ->join('profiles', 'student_council.student_id', '=', 'profiles.student_id')
            ->join('programs', 'profiles.program_id', '=', 'programs.program_id')
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
    }

    public function recordSrcPostWinner($candidateStudentId)
    {
        $candidateService = new CandidateService();
        $candidateProfile = $this->getCandidateProfile($candidateStudentId);
        $candidateSrcPost = $candidateService->getCandidateSrcPostId($candidateStudentId);

        $this->addSrcMember(
            $candidateStudentId,
            $candidateSrcPost->src_post_id,
            $candidateProfile->profile_url,
            $candidateProfile->contact
        );
    }

    public function recordVP($candidateStudentId)
    {
        $candidateProfile = $this->getCandidateProfile($candidateStudentId);
        $candidateSrcPostId = SrcPostConstants::VP['src_post_id'];

        $this->addSrcMember(
            $candidateStudentId,
            $candidateSrcPostId,
            $candidateProfile->profile_url,
            $candidateProfile->contact
        );
    }

    public function addSrcMember($candidateStudentId, $candidateSrcPostId, $candidateProfileUrl, $candidateContact)
    {
        if ($this->candidateExistsInTheCouncil($candidateStudentId)) return;

        StudentCouncil::create([
            'student_id' => $candidateStudentId,
            'src_post_id' => $candidateSrcPostId,
            'profile_url' => $candidateProfileUrl,
            'contact' => $candidateContact
        ]);
    }

    public function candidateExistsInTheCouncil($candidateStudentId)
    {
        return StudentCouncil::where('student_id', $candidateStudentId)->exists();
    }

    public function getCandidateProfile($candidateStudentId)
    {
        return CandidateProfile::where('student_id', $candidateStudentId)->first();
    }

    public function setAllPortalStatusesToInActive()
    {
        //Set all active portal status to NO 
        DB::table('portal_status')
            ->update([
                'active' => PortalStatusConstants::INACTIVE
            ]);
    }

    public function setPortalStatusToStudentCouncil()
    {
        $this->setAllPortalStatusesToInActive();

        PortalStatus::where('status', PortalStatusConstants::FEED)
            ->update(['active' => PortalStatusConstants::ACTIVE]);
    }
}
