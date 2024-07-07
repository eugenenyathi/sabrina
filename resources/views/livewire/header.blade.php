<?php

use App\Models\Student;
use App\Models\Candidate;
use App\Constants\Profiles;
use App\Models\CandidateProfile;
use Illuminate\Support\Facades\Auth;
use function Livewire\Volt\{state, computed, mount};

state([
    'profileUrl' => '',
    'fullName' => '',
    'no_profile' => 'no-profile.png',
]);

$user = computed(fn() => Auth::user());

mount(function () {
    $student = Student::select('fullName')
        ->where('student_id', $this->user->student_id)
        ->first();

    $studentIsACandidate = Candidate::where('student_id', $this->user->student_id)->exists();

    switch ($studentIsACandidate) {
        case true:
            $candidateProfile = CandidateProfile::where('student_id', $this->user->student_id)->first();
            $this->profile_url = $candidateProfile->profile_url ?? $this->no_profile;
            break;
        case false:
            $randomProfile = Profiles::ITEMS[mt_rand(0, count(Profiles::ITEMS) - 1)];
            $this->profile_url = 'SRC\\profiles\\' . $randomProfile;
            break;
    }

    $this->fullName = $student->fullName;
});

//TODO: ADD A LOGOUT BUTTON

?>

<div class="fixed top-0 left-0 right-0 z-50 bg-white border-b-2 border-b-scarlet">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center py-3">
            <h2 class="font-custom text-4xl bg-gradient-to-r from-amber-500 to-pink-500 bg-clip-text text-transparent">
                Sabrina
            </h2>
            <x-avatar image="{{ asset('/storage/' . $this->profile_url) }}" title="{{ $this->fullName }}" class="!w-11" />
        </div>
    </div>
</div>
