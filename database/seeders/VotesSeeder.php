<?php

namespace Database\Seeders;

use App\Traits\Utils;
use Illuminate\Database\Seeder;
use App\Http\Services\VotesService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VotesSeeder extends Seeder
{
    use Utils;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $votesService = new VotesService();
        $votersRatios = [0.42, 0.58, 0.72, 0.34, 0.19];
        $srcPosts = $votesService->getAllSrcPostIds();

        foreach ($srcPosts as $srcPost) {
            //grab candidates by src_post_id
            $candidates = $votesService->getCandidatesBySrcPostId($srcPost->src_post_id);

            foreach ($candidates as $candidateCount => $candidate) {
                //for each fresh candidate we refetch the voters
                $voters = $this->voters($votesService, $srcPost->src_post_id);
                $votersCount = count($voters);

                switch (count($candidates)) {
                    case 2:
                        if ($candidateCount === 0)
                            $votersCount = floor(count($voters) * $votersRatios[$this->random(0, count($votersRatios) - 1)]);
                        break;
                    default:
                        if ($candidateCount === 0)
                            $votersCount = floor(count($voters) * $votersRatios[$this->random(0, count($votersRatios) - 1)]);
                        else if ($candidateCount === 1)
                            $votersCount = floor(count($voters) * $votersRatios[$this->random(0, count($votersRatios) - 1)]);
                }

                $this->recordVote($votesService, $votersCount, $voters, $candidate);
            }
        }

        $this->updatePortalStatus($votesService);
    }

    private function recordVote($votesService, $votersCount, $voters, $candidate)
    {
        for ($i = 1; $i < $votersCount; $i++) {
            $voterId = $voters[$i];
            $votesService->freshVote($voterId, $candidate->student_id);
        }
    }

    private function voters($votesService, $srcPostId)
    {
        $voters = $votesService->getVoters();
        return $this->filterVoters($votesService, $voters, $srcPostId);
    }

    private function filterVoters($votesService, $voters, $srcPostId)
    {
        $filteredVoters = [];

        foreach ($voters as $voter) {
            $allCandidatesVotedForByVoter = $votesService->getAllCandidatesVotedForByVoter($voter->student_id);

            if (count($allCandidatesVotedForByVoter)) {
                foreach ($allCandidatesVotedForByVoter as $count => $votedForCandidate) {
                    $votedForCandidateSrcPost = $votesService->getCandidateSrcPostId($votedForCandidate->candidate_id);
                    //if the src_post_id's match it means this voter has already voted for this particular post
                    if ($votedForCandidateSrcPost->src_post_id === $srcPostId) break;
                    if ($count == count($allCandidatesVotedForByVoter) - 1)
                        $filteredVoters = $this->addVoter($filteredVoters, $voter->student_id);
                }
            } else $filteredVoters = $this->addVoter($filteredVoters, $voter->student_id);
        }

        return $filteredVoters;
    }

    private function addVoter($filteredVoters, $voterId)
    {
        if (!in_array($voterId, $filteredVoters)) {
            $filteredVoters[] = $voterId;
        }

        return $filteredVoters;
    }

    private function updatePortalStatus($votesService)
    {
        //Set all active portal status to NO 
        $votesService->setAllPortalStatusesToInActive();
        //set the candidate on-boarding status to active
        $votesService->setPortalStatusToVoting();
    }
}
