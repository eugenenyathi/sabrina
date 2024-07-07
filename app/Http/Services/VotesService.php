<?php

namespace App\Http\Services;

use App\Models\Vote;
use App\Models\Profile;
use App\Models\SrcPost;
use App\Models\Candidate;
use App\Models\VoteCount;
use App\Models\PortalStatus;
use App\Constants\VoteCountEffect;
use Illuminate\Support\Facades\DB;
use App\Constants\PortalStatusConstants;
use App\Constants\SrcPostConstants;

class VotesService
{
    public function getAllSrcPostIds()
    {
        return SrcPost::select('src_post_id')->whereNot('src_post_id', SrcPostConstants::VP['src_post_id'])->get();
    }

    public function getCandidateSrcPostId($candidateStudentId)
    {
        return Candidate::select('src_post_id')->where('student_id', $candidateStudentId)->first();
    }

    public function getCandidatesBySrcPostId($srcPostId)
    {
        return Candidate::select('student_id')->where('src_post_id', $srcPostId)->get();
    }

    public function getCandidatesVotedForByVoter($candidateStudentId, $voterStudentId)
    {
        return Vote::select('candidate_id')->where('voter_id', $voterStudentId)
            ->whereNot('candidate_id', $candidateStudentId)
            ->get();
    }

    public function getAllCandidatesVotedForByVoter($voterStudentId)
    {
        return Vote::select('candidate_id')->where('voter_id', $voterStudentId)->get();
    }

    public function getAllCandidates()
    {
        return Candidate::select('student_id')->get()->pluck('student_id');
    }

    public function getVoters()
    {
        $excludedParts = [3.1, 3.2];
        $candidates = $this->getAllCandidates();

        return Profile::select('student_id')
            ->whereNotIn('part', $excludedParts)
            ->whereNotIn('student_id', $candidates)
            ->inRandomOrder()
            ->get();
    }

    public function deleteOldVote($candidateStudentId, $voterStudentId)
    {
        Vote::where('candidate_id', $candidateStudentId)->where('voter_id', $voterStudentId)->delete();
    }

    public function getCandidateVoteCount($candidateStudentId)
    {
        return VoteCount::select('votes')->where('candidate_id', $candidateStudentId)->first();
    }

    public function voteForCandidateAlreadyExists($voterStudentId, $candidateStudentId)
    {
        return Vote::where('candidate_id', $candidateStudentId)->where('voter_id', $voterStudentId)->exists();
    }

    public function recordVote($voterStudentId, $candidateStudentId)
    {
        Vote::create([
            'candidate_id' => $candidateStudentId,
            'voter_id' => $voterStudentId
        ]);
    }

    public function removeVote($voterStudentId, $candidateStudentId)
    {
        Vote::where('candidate_id', $candidateStudentId)->where('voter_id', $voterStudentId)->delete();

        $this->updateVoteCount($candidateStudentId, VoteCountEffect::REDUCE);
    }

    public function createVoteCount($candidateStudentId)
    {
        VoteCount::create(['candidate_id' => $candidateStudentId, 'votes' => 1]);
    }


    public function freshVote($voterStudentId, $candidateStudentId)
    {
        //record vote
        $this->recordVote($voterStudentId, $candidateStudentId);

        //check if the candidate has any votes
        $candidateHasVotes = $this->doesCandidateHasVotes($candidateStudentId);

        switch ($candidateHasVotes) {
            case true:
                $this->updateVoteCount($candidateStudentId, VoteCountEffect::ADD);
                break;
            case false:
                $this->createVoteCount($candidateStudentId);
                break;
        }
    }

    public function updateVoteCount($candidateStudentId, $effect)
    {
        $candidateVotes = $this->getCandidateVoteCount($candidateStudentId);

        switch ($effect) {
            case VoteCountEffect::ADD:
                VoteCount::where('candidate_id', $candidateStudentId)->update(['votes' => $candidateVotes->votes + 1]);
                break;
            case VoteCountEffect::REDUCE:
                VoteCount::where('candidate_id', $candidateStudentId)->update(['votes' => $candidateVotes->votes - 1]);
                break;
        }
    }

    public function doesCandidateHasVotes($candidateStudentId)
    {
        return VoteCount::where('candidate_id', $candidateStudentId)->exists();
    }

    public function voterVotedForCandidate($voterStudentId, $candidateStudentId)
    {
        return Vote::where('candidate_id', $candidateStudentId)->where('voter_id', $voterStudentId)->exists();
    }

    public function getCandidateVotes($candidateStudentId)
    {
        return VoteCount::select('votes')->where('candidate_id', $candidateStudentId)->first();
    }

    public function highestVotesCandidates($srcPostId)
    {
        return DB::table('candidates')
            ->where('candidates.src_post_id', $srcPostId)
            ->join('votes', 'candidates.student_id', '=', 'votes.candidate_id')
            ->join('votes_count', 'candidates.student_id', '=', 'votes_count.candidate_id')
            ->select('candidates.student_id', 'candidates.src_post_id', 'votes_count.votes')
            ->distinct()
            ->orderBy('votes_count.votes', 'desc')
            ->get();
    }

    public function rankVotes($srcPostId)
    {
        return DB::table('votes')
            ->join('candidates', 'votes.candidate_id', '=', 'candidates.student_id')
            ->join('votes_count', 'votes.candidate_id', '=', 'votes_count.candidate_id')
            ->select('votes_count.candidate_id', 'votes_count.votes', 'candidates.src_post_id')
            ->where('candidates.src_post_id', $srcPostId)
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

    public function setPortalStatusToVoting()
    {
        PortalStatus::where('status', PortalStatusConstants::VOTING)
            ->update(['active' => PortalStatusConstants::ACTIVE]);
    }
}
