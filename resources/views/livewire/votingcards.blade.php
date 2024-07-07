<?php

use App\Models\Candidate;
use App\Constants\SrcPostConstants;
use App\Http\Services\VotesService;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\CandidateService;
use App\Http\Controllers\VotesController;
use function Livewire\Volt\{state, mount, computed, on};

state(['candidates' => []]);

$user = computed(fn() => Auth::user());

on([
    'votingpost-updated' => function ($src_post_id) {
        $candidateService = new CandidateService();
        $this->candidates = $candidateService->getCandidatesDeep($src_post_id);
    },
]);

mount(function () {
    $candidateService = new CandidateService();
    $this->candidates = $candidateService->getCandidatesDeep(SrcPostConstants::PRESIDENT['src_post_id']);
});

$vote = function ($candidateId) {
    $votesService = new VotesService();
    $votesController = new VotesController($votesService);

    $votesController->vote($this->user->student_id, $candidateId);

    foreach ($this->candidates as $candidate) {
        if ($candidateId == $candidate->student_id) {
            $candidate->votes += 1;
        } else {
            $voterVotedForCandidate = $votesService->voterVotedForCandidate($this->user->student_id, $candidate->student_id);
            if ($voterVotedForCandidate) {
                $candidate->votes -= 1;
            }
        }
    }
};

$removeVote = function ($candidateId) {
    $votesService = new VotesService();
    $votesService->removeVote($this->user->student_id, $candidateId);
};

$voteStatus = function ($candidate) {
    //check if the voter voted for this candidate, if yes change the icon and remove the vote event
    $votesService = new VotesService();
    return $votesService->voterVotedForCandidate($this->user->student_id, $candidate->student_id);
};
?>

<div>
    @forelse ($this->candidates as $candidate)
        <div class="w-full mb-4 rounded-md bg-white border border-neutral-200 ">

            <div class="p-3">
                <x-avatar image="{{ asset('/storage/' . $candidate->profile_url) }}" title="{{ $candidate->fullName }}"
                    subtitle="{{ $candidate->program }} - Part {{ $candidate->part }}" class="!w-11 cursor-pointer" />
            </div>

            {{-- Image container --}}
            <div>
                <img src="{{ asset('/storage/' . $candidate->profile_url) }}" alt="{{ $candidate->fullName }}"
                    class="w-full max-h-96 object-cover object-top">
            </div>


            {{-- Votes Container --}}
            <div class="p-4">
                <p class="mb-3 text-sm font-medium">{{ $candidate->catch_phrase }}</p>

                <div class="flex items-center gap-2">

                    @if ($this->voteStatus($candidate))
                        <x-bi-heart-fill class="w-6 h-6 cursor-pointer text-red-600"
                            wire:click="removeVote('{{ $candidate->student_id }}')" />
                    @else
                        <x-bi-heart class="w-6 h-6 cursor-pointer" wire:click="vote('{{ $candidate->student_id }}')" />
                    @endif

                    <p class="font-semibold">{{ $candidate->votes ?? 0 }} votes</p>
                </div>
            </div>


        </div>
    @empty
        <h2>Nothing to show</h2>
    @endforelse
</div>
