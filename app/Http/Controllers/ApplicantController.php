<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Constants\ApplicantStatus;
use App\Http\Services\ApplicantService;
use App\Traits\HttpResponses;

class ApplicantController extends Controller
{

    use HttpResponses;

    public function __construct(private ApplicantService $applicantService)
    {
    }

    public function approveApplicant($applicantId)
    {
        //check if the applicant has been approved already
        $applicant = $this->applicantService->applicantApproved($applicantId);

        if ($applicant->approval_status === ApplicantStatus::APPROVED) return;

        $this->applicantService->approveApplicant($applicantId);
    }

    public function declineApplicant($applicantId)
    {
        //check if the applicant has been declined already
        $applicant = $this->applicantService->applicantApproved($applicantId);

        if ($applicant->approval_status === ApplicantStatus::DECLINED) return;

        //check if applicant is the only applicant, if so they can't be declined
        $applicantSrcPost = $this->applicantService->applicantSrcPostId($applicantId);
        //get all applicants of the same src_post
        $applicants = $this->applicantService->getApplicantsBySrcPostId($applicantSrcPost->src_post_id);

        if (count($applicants) > 1) $this->applicantService->declineApplicant($applicantId);
    }
}
