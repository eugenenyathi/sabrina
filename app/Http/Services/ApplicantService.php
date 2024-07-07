<?php

namespace App\Http\Services;

use App\Models\Profile;
use App\Models\SrcPost;
use App\Models\Applicant;
use App\Models\Candidate;
use App\Constants\ApplicantStatus;
use App\Constants\SrcPostConstants;

class ApplicantService
{

    public function applicants()
    {
        $excludedParts = [3.1, 3.2, 2.2, 1.1];

        return Profile::select('student_id')
            ->whereNotIn('part', $excludedParts)
            ->inRandomOrder()
            ->limit(3)
            ->get();
    }

    public function isStudentAnApplicant($applicantId)
    {
        return Applicant::where('student_id', $applicantId)->exists();
    }

    public function getSrcPosts()
    {
        return SrcPost::select('src_post_id')
            ->whereNot('src_post_id', SrcPostConstants::VP['src_post_id'])
            ->get();
    }

    public function getApplicantsBySrcPostId($srcPostId)
    {
        return Applicant::select('student_id', 'src_post_id')
            ->where('src_post_id', $srcPostId)
            ->get();
    }

    public function doesCandidateExist($applicantId)
    {
        return Candidate::where('student_id', $applicantId)->exists();
    }

    public function updateApplicantApprovalStatus($applicantId, $approval)
    {
        Applicant::where('student_id', $applicantId)
            ->update([
                'approval_status' => $approval
            ]);
    }

    public function getApprovedApplicants()
    {
        return Applicant::select('student_id', 'src_post_id')
            ->where('approval_status', ApplicantStatus::APPROVED)
            ->get();
    }

    public function createApplicant($applicantId, $srcPostId, $profileUrl)
    {
        Applicant::create([
            'student_id' => $applicantId,
            'src_post_id' => $srcPostId,
            'profile_url' => $profileUrl
        ]);
    }

    public function applicantApproved($applicantId)
    {
        return Applicant::select('approval_status')->where('student_id', $applicantId)->first();
    }

    public function approveApplicant($applicantId)
    {
        Applicant::where('student_id', $applicantId)->update(['approval_status' => ApplicantStatus::APPROVED]);
    }

    public function declineApplicant($applicantId)
    {
        Applicant::where('student_id', $applicantId)->update(['approval_status' => ApplicantStatus::DECLINED]);
    }

    public function applicantSrcPostId($applicantId)
    {
        return Applicant::select('src_post_id')->where('student_id', $applicantId)->first();
    }
}
