<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\SrcPost;
use App\Models\Student;
use App\Models\Applicant;
use Illuminate\Database\Seeder;
use App\Constants\ApplicantStatus;
use App\Constants\SrcPostConstants;
use App\Http\Services\ApplicantService;
use App\Http\Controllers\ApplicantController;
use App\Traits\Utils;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ApplicantSeeder extends Seeder
{
    use Utils;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $applicantService = new ApplicantService();

        $this->createApplicants($applicantService);
        $this->approveApplicants($applicantService);
    }

    private function createApplicants($applicantService)
    {
        $srcPosts = $applicantService->getSrcPosts();

        //Per each src-post get 3 random applicants
        foreach ($srcPosts as $srcPost) {
            $applicants = $applicantService->applicants();

            foreach ($applicants as $applicant) {
                //verify if student is not already an applicant
                $isStudentAnApplicant = $applicantService->isStudentAnApplicant($applicant->student_id);

                if (!$isStudentAnApplicant) {
                    $applicantService->createApplicant($applicant->student_id, $srcPost->src_post_id, "SRC\\no-profile.png");
                }
            }
        }
    }

    private function approveApplicants($applicantService)
    {
        $approvalStatus = [ApplicantStatus::APPROVED, ApplicantStatus::DECLINED];

        $srcPosts = $applicantService->getSrcPosts();

        foreach ($srcPosts as $srcPost) {
            $applicants = $applicantService->getApplicantsBySrcPostId($srcPost->src_post_id);

            $approval = ApplicantStatus::APPROVED;

            foreach ($applicants as $key => $applicant) {

                $applicantIsACandidate = $applicantService->doesCandidateExist($applicant->student_id);

                if (!$applicantIsACandidate) {
                    if ($key === count($applicants) - 1)
                        $approval = $approvalStatus[$this->random(0, count($approvalStatus) - 1)];

                    $applicantService->updateApplicantApprovalStatus($applicant->student_id, $approval);
                }
            }
        }
    }
}
