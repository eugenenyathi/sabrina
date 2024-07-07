<?php

use Carbon\Carbon;
use App\Models\PortalStatus;
use function Livewire\Volt\{computed};
use App\Constants\PortalStatusConstants;

$votingClosingDate = computed(function () {
    $date = PortalStatus::select('closing_date')
        ->where('status', PortalStatusConstants::VOTING)
        ->first();

    $__date = Carbon::parse($date->closing_date);

    return $__date->format('l d F');
});

?>



<div class="w-full bg-scarlet rounded-md p-3 mb-4 flex items-center gap-2">
    <x-icon name="o-fire" class="w-6 h-6 text-white" />
    <p class="font-semibold text-base text-white">Voting closes {{ $this->votingClosingDate }}</p>
</div>
