<?php

namespace App\Http\Controllers;

use App\Http\Services\VotesService;
use App\Models\Applicant;
use App\Models\Candidate;
use App\Traits\HttpResponses;
use App\Traits\Utils;
use Illuminate\Http\Request;

class BirdsViewController extends Controller
{
    use Utils;
    use HttpResponses;

    public function applicants()
    {
        $applicantProfiles = [];
        $applicants = Applicant::select('student_id', 'src_post_id')->get();

        foreach ($applicants as $applicant) {
            $studentProfile = $this->studentProfile($applicant->student_id);
            $studentProfile['src_post'] = $this->getSRCPost($applicant->src_post_id);

            $applicantProfiles[] = $studentProfile;
        }

        return $this->sendData($applicantProfiles);
    }

    public function candidates()
    {
        $candidates = Candidate::all();

        return $this->sendData($candidates);
    }

    public function voters()
    {
        $votesService = new VotesService();
        return $this->sendData($votesService->getVoters());
    }
}
