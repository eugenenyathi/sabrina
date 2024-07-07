<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Http\Services\ApplicantService;
use App\Http\Services\CandidateService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CandidateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $applicantService = new ApplicantService();
        $applicants = $applicantService->getApprovedApplicants();

        $candidateService = new CandidateService();

        foreach ($applicants as $applicant) {
            $candidateService->createCandidate($applicant->student_id, $applicant->src_post_id);
        }

        $this->updatePortalStatus($candidateService);
    }

    private function updatePortalStatus($candidateService)
    {
        //Set all active portal status to NO 
        $candidateService->setAllPortalStatusesToInActive();
        //set the candidate on-boarding status to active
        $candidateService->setPortalStatusToCandidateOnboarding();
    }
}
