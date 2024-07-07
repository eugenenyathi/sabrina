<?php

namespace App\Http\Controllers;

use App\Constants\SrcPostConstants;
use App\Http\Services\SrcService;
use App\Http\Services\VotesService;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class VotingResultsController extends Controller
{
    use HttpResponses;

    public function __construct(
        private VotesService $votesService,
        private SrcService $srcService
    ) {
    }

    public function countVotes__()
    {
        $this->countVotes();
        return $this->sendResponse('Done');
    }

    public function countVotes()
    {
        $srcPosts = $this->votesService->getAllSrcPostIds();

        foreach ($srcPosts as $srcPost) {
            $highestVotesCandidates = $this->votesService->highestVotesCandidates($srcPost->src_post_id);

            if (count($highestVotesCandidates)) {
                if ($srcPost->src_post_id === SrcPostConstants::PRESIDENT['src_post_id']) {
                    $secondHighestCandidate = $highestVotesCandidates[1];
                    $this->srcService->recordVP($secondHighestCandidate->student_id);
                }

                //record the winner
                $this->srcService->recordSrcPostWinner($highestVotesCandidates[0]->student_id);
            }
        }

        //update portal status
        $this->srcService->setPortalStatusToStudentCouncil();
    }
}
