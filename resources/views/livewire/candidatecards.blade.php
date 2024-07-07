<?php

use App\Http\Services\SRCService;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\CandidateService;
use App\Constants\PortalStatusConstants;
use function Livewire\Volt\{state, mount, computed};

state(['studentIsACandidate' => null, 'records' => []]);

$user = computed(fn() => Auth::user());

mount(function () {
    $candidateService = new CandidateService();
    $srcService = new SRCService();

    $this->studentIsACandidate = $candidateService->isStudentACandidate($this->user->student_id);

    if ($this->studentIsACandidate) {
        // get the candidates src_post_id and fetch the competing candidates
        $candidateSrcPost = $candidateService->getCandidateSrcPostId($this->user->student_id);
        $this->records = $candidateService->getCandidatesDeep($candidateSrcPost->src_post_id);
    } else {
        $this->records = $srcService->getSRCMembers();
    }
});

$vote = function (Candidate $candidate) {};
?>

<div>
    @foreach ($this->records as $record)
        <div class="w-full mb-4 rounded-md bg-white border border-neutral-200 ">

            <div class="p-3">
                <x-avatar image="{{ asset('/storage/' . $record->profile_url) }}" title="{{ $record->fullName }}"
                    subtitle="{{ $record->program }} - Part {{ $record->part }}" class="!w-11 cursor-pointer" />
            </div>

            {{-- Image container --}}
            <div>
                <img src="{{ asset('/storage/' . $record->profile_url) }}" alt="{{ $record->fullName }}"
                    class="w-full max-h-96 object-cover object-top">
            </div>


            <div class="p-3 ">
                @if ($this->studentIsACandidate)
                    <p class="mb-3 text-sm font-medium">{{ $record->catch_phrase }}</p>
                @else
                    <div class="flex items-center gap-2">
                        <x-bi-phone class="w-6 h-6 cursor-pointer" />
                        <p class="mb-3 text-sm font-medium">{{ $record->contact }}</p>
                    </div>
                @endif
            </div>

        </div>
    @endforeach
</div>
