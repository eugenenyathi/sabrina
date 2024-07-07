<?php

use App\Models\Applicant;
use App\Models\CandidateProfile;
use Illuminate\Support\Facades\Auth;
use function Livewire\Volt\{state, mount, computed};

state(['onboard_url' => '/onboard-candidate', 'edit_url' => '/update-candidate-profile', 'candidateOnboarded' => null]);

$user = computed(fn() => Auth::user());

mount(function () {
    $this->candidateOnboarded = CandidateProfile::where('student_id', $this->user->student_id)->exists();
});

$editCandidateProfile = fn() => redirect()->intended($this->edit_url);
$onboard = fn() => redirect()->intended($this->onboard_url);

?>

<div>
    @if ($this->candidateOnboarded)
        <div class="w-full bg-scarlet rounded-md p-3 mb-4 flex items-center gap-2 cursor-pointer"
            wire:click='editCandidateProfile'>
            <x-icon name="m-sparkles" class="w-5 h-5 text-white" />
            <p class="font-semibold text-base text-white">Edit Candidate Profile</p>
        </div>
    @else
        <div class="w-full bg-scarlet rounded-md p-3 mb-4 flex items-center gap-2 cursor-pointer" wire:click='onboard'>
            <x-icon name="o-fire" class="w-6 h-6 text-white" />
            <p class="font-semibold text-base text-white">Create Candidate Profile</p>
        </div>
    @endif
</div>
