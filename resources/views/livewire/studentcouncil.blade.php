<?php

use App\Http\Services\SrcService;
use App\Constants\SrcPostConstants;
use function Livewire\Volt\{computed};

// state(['studentCouncil' => []])

// mount(function () {
//     $srcService = new SrcService();
//     $this->studentCouncil = $srcService->getSRCMembers();
// });

$studentCouncil = computed(function () {
    $srcService = new SrcService();
    return $srcService->getSRCMembers();
});

?>

<div>
    @foreach ($this->studentCouncil as $student)
        <div class="w-full mb-4 rounded-md bg-white border border-neutral-200 ">

            <div class="p-3">
                <x-avatar image="{{ asset('/storage/' . $student->profile_url) }}" title="{{ $student->fullName }}"
                    subtitle="{{ $student->post }} - {{ $student->program }} - Part {{ $student->part }}"
                    class="!w-11 cursor-pointer" />
            </div>

            {{-- Image container --}}
            <div>
                <img src="{{ asset('/storage/' . $student->profile_url) }}" alt="{{ $student->fullName }} profile picture"
                    class="w-full max-h-96 object-cover object-top">
            </div>

            <div class="p-3 ">
                <div class="flex items-center gap-2">
                    <x-bi-phone class="w-6 h-6 cursor-pointer" />
                    <p class="mb-3 text-sm font-medium">{{ $student->contact }}</p>
                </div>
            </div>

        </div>
    @endforeach
</div>
