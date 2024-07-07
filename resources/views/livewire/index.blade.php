<?php

use App\Models\SrcPost;
use App\Models\Student;
use App\Models\PortalStatus;
use Illuminate\Support\Facades\Auth;
use App\Constants\PortalStatusConstants;
use function Livewire\Volt\{state, computed};

$user = computed(fn() => Auth::user());

$portalStatus = computed(function () {
    $status = PortalStatus::where('active', PortalStatusConstants::ACTIVE)->first();
    return $status->status;
});

?>

<div class="m-h-screen w-full bg-neutral-50">

    <livewire:header />

    <div class="relative top-28
        w-full z-10">

        @if ($this->portalStatus == PortalStatusConstants::VOTING)
            <div class="absolute left-52 w-[482px]">
                <livewire:voting-alert />
                <livewire:votingcards />
            </div>

            <livewire:votingposts />
        @else
            <div class="absolute left-80 w-[482px]">
                @switch($this->portalStatus)
                    @case(PortalStatusConstants::APPLICATION)
                        {{-- run for office alert --}}
                        <livewire:apply-alert />
                        <livewire:studentcouncil />
                    @break

                    @case(PortalStatusConstants::CANDIDATE_ONBOARDING)
                        {{-- candidate profile onboarding --}}
                        <livewire:onboarding-alert />
                        <livewire:candidatecards />
                    @break

                    @default
                        <livewire:studentcouncil />
                @endswitch

            </div>
        @endif

    </div>

</div>
