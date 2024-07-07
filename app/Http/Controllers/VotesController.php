<?php

namespace App\Http\Controllers;

use App\Traits\Utils;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Constants\VoteCountEffect;
use App\Http\Services\VotesService;

class VotesController extends Controller
{
    use Utils;
    use HttpResponses;

    public function __construct(private VotesService $votesService)
    {
    }

    public function vote__(Request $request)
    {
        $request->validate([
            'voter_id' => 'required|string|max:9|regex: /^L0\d{6}[A-Z]{1}$/u',
            'candidate_id' => 'required|string|max:9|regex: /^L0\d{6}[A-Z]{1}$/u'
        ]);

        $this->vote($request->voter_id, $request->candidate_id);

        return $this->sendResponse("You have successfully voted!");
    }

    public function vote($voterStudentId, $candidateStudentId)
    {
        /**
         * 1. Check if this voter has already voted for the incoming candidate
         * 2. Check if the current voter did not vote already for another candidate in the same voting post
         * 3. If they have voted, remove the vote from the old candidate and add the vote to the new candidate
         * 4. If not add the vote to candidate
         */

        $voteForCandidateAlreadyExists = $this->votesService->voteForCandidateAlreadyExists($voterStudentId, $candidateStudentId);

        if ($voteForCandidateAlreadyExists) return;

        //TODO: validate the voter_id and if the candidate_id is actually a candidate
        //TODO: you cant vote if the portal status is not on voting status
        $voteForCompetingCandidateExists = $this->voteForCompetingCandidateExists($voterStudentId, $candidateStudentId);

        switch ($voteForCompetingCandidateExists) {
            case true:
                $this->voteExists($voterStudentId, $candidateStudentId);
                break;
            case false:
                $this->votesService->freshVote($voterStudentId, $candidateStudentId);
                break;
        }
    }

    private function voteExists($voterStudentId, $candidateStudentId)
    {
        //Get src_post_id for the candidate with the oncoming vote
        $incomingCandidateVote = $this->votesService->getCandidateSrcPostId($candidateStudentId);
        $candidatesVotedForByStudent = $this->votesService->getCandidatesVotedForByVoter($candidateStudentId, $voterStudentId);

        foreach ($candidatesVotedForByStudent as $candidate) {
            //get the src_post_id for the candidate in question
            $candidateSrcPostId = $this->votesService->getCandidateSrcPostId($candidate->candidate_id);

            //check if the candidate in question src_post_id matches the target src_post_id
            if ($incomingCandidateVote->src_post_id === $candidateSrcPostId->src_post_id) {
                //Delete the old vote by the student
                $this->votesService->deleteOldVote($candidate->candidate_id, $voterStudentId);
                //Reduce the vote count
                $this->votesService->updateVoteCount($candidate->candidate_id, VoteCountEffect::REDUCE);
            }
        }
        //record the vote
        $this->votesService->freshVote($voterStudentId, $candidateStudentId);
    }

    private function voteForCompetingCandidateExists($voterStudentId, $candidateStudentId)
    {
        //Get src_post_id for the candidate with the oncoming vote
        $incomingCandidateVote = $this->votesService->getCandidateSrcPostId($candidateStudentId);
        $candidatesVotedForByStudent = $this->votesService->getCandidatesVotedForByVoter($candidateStudentId, $voterStudentId);

        foreach ($candidatesVotedForByStudent as $candidate) {

            //get the src_post_id for the candidate in question
            $candidateSrcPostId = $this->votesService->getCandidateSrcPostId($candidate->candidate_id);

            //check if the candidate in question src_post_id matches the target src_post_id
            if ($incomingCandidateVote->src_post_id === $candidateSrcPostId->src_post_id)
                return true;
        }

        return false;
    }
}
