<?php

use App\Models\Applicant;
use Illuminate\Support\Facades\Auth;
use function Livewire\Volt\{state, mount, computed};

state(['apply_url' => '/apply', 'edit_url' => '/edit-application', 'applicationStatus' => false]);

$user = computed(fn() => Auth::user());

mount(function () {
    $this->applicationStatus = Applicant::where('student_id', $this->user->student_id)->exists();
});

$editApplication = fn() => redirect()->intended($this->edit_url);
$apply = fn() => redirect()->intended($this->apply_url);

?>

<div>
    @if ($this->applicationStatus)
        <div class="w-full bg-orange-500 rounded-md p-3 mb-4 flex items-center gap-2 cursor-pointer"
            wire:click='editApplication'>
            <x-icon name="m-sparkles" class="w-5 h-5 text-white" />
            <p class="font-semibold text-base text-white">Edit Application</p>
        </div>
    @else
        <div class="w-full bg-scarlet rounded-md p-3 mb-4 flex items-center gap-2 cursor-pointer" wire:click='apply'>
            <x-icon name="o-fire" class="w-6 h-6 text-white" />
            <p class="font-semibold text-base text-white">Run for Office</p>
        </div>
    @endif
</div>
