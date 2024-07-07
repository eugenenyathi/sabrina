<?php

use App\Models\CandidateProfile;
use Illuminate\Support\Facades\Storage;
use function Livewire\Volt\{state, computed, rules, usesFileUploads};

usesFileUploads();

state([
    'profile_url' => null,
    'bio' => '',
    'catch_phrase' => '',
    'contact' => '0774562079',
    'redirect_url' => '/',
]);

$user = computed(fn() => Auth::user());

rules([
    'profile_url' => 'required|image',
    'bio' => 'required|string|min:10',
    'catch_phrase' => 'required|string|min:5',
    'contact' => 'required|string|min:10|max:10',
])
    ->messages([
        'profile_url.required' => 'The :attribute can not be empty.',
        'bio.required' => 'The :attribute can not be empty.',
    ])
    ->attributes([
        'profile_url' => 'profile picture',
        'catch_phrase' => 'catch phrase',
    ]);

$updateApplication = function () {
    if ($this->profile_url && $this->profile_url->temporaryUrl()) {
        $this->validate();
        $this->createCandidateProfile();
        //TODO:Toast message
        return redirect()->intended($this->redirect_url);
    } else {
        $this->validate();
    }
};

$createCandidateProfile = function () {
    CandidateProfile::create([
        'student_id' => $this->user->student_id,
        'profile_url' => $this->profile_url->store('SRC'),
        'bio' => $this->bio,
        'catch_phrase' => $this->catch_phrase,
        'contact' => $this->contact,
    ]);
};

?>

<div class="min-h-screen flex justify-center items-center">
    <x-form wire:submit.prevent='updateApplication' enctype="multipart/form-data" class="w-2/3 ">

        <div class="w-full flex  justify-between items-center gap-6" x-data="{ showUploadedImg: false, uploadedImg: '' }">
            <div class="basis-2/5">
                <div class="w-full flex flex-col justify-center items-center">

                    <label x-show="!showUploadedImg" for="profile_url"
                        class="size-48 flex justify-center items-center bg-orange-500 cursor-pointer shadow rounded-full overflow-hidden mb-3 ">
                        <x-icon name="o-camera" class="w-7 h-7 text-white" />
                    </label>

                    {{-- //TODO: IMPLEMENT HOVER EFFECT TO CHANGE UPLOADED PROFILE PICTURE --}}
                    <div x-show="showUploadedImg" class="size-48 rounded-full overflow-hidden mb-3 ">
                        <img :src="uploadedImg" alt="no-uploaded-img" class="s-full object-cover object-top" />
                    </div>


                    <h1 class="font-medium mt-2">Profile Picture</h1>


                    <input type="file" id="profile_url" wire:model="profile_url" class="shadow hidden"
                        @change=" showUploadedImg = true, uploadedImg = URL.createObjectURL($event.target.files[0])" />


                    @error('profile_url')
                        <span class="text-red-400 text-xs mt-1">{{ $message }}</span>
                    @enderror

                </div>

            </div>

            <div class="basis-3/5">
                <div class="mb-2">
                    <x-textarea label="Bio" wire:model="bio" placeholder="Why are running for office ..."
                        hint="Max 1000 chars" rows="5"
                        class="focus:outline-orange-500 focus:border-orange-500 border-orange-500 peer-focus:label:text-orange-500" />
                </div>

                <div class="mb-2">
                    <x-textarea label="Catch phrase" wire:model="catch_phrase" placeholder="..." hint="Max 50 chars"
                        rows="2"
                        class="focus:outline-orange-500 focus:border-orange-500 border-orange-500 peer-focus:label:text-orange-500" />
                </div>

                <div class="mb-2">
                    <x-input label="Phone" wire:model='contact' placeholder="77 123 4567" icon="o-phone"
                        class="focus:outline-orange-500 focus:border-orange-500 border-orange-500 peer-focus:label:text-orange-500" />
                </div>

                <x-slot:actions>
                    <x-button label="Save" type="submit" spinner="login"
                        class="capitalize bg-orange-600 text-white" />
                </x-slot:actions>
            </div>
        </div>

    </x-form>
</div>
