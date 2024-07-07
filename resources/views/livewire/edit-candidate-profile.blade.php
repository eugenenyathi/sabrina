<?php

use App\Models\CandidateProfile;
use Illuminate\Support\Facades\Storage;
use function Livewire\Volt\{state, mount, computed, rules, usesFileUploads};

usesFileUploads();

state([
    'upload_profile' => null,
    'profile_url' => null,
    'bio' => '',
    'catch_phrase' => '',
    'contact' => '',
    'redirect_url' => '/',
]);

$user = computed(fn() => Auth::user());

mount(function () {
    $candidateProfile = CandidateProfile::where('student_id', $this->user->student_id)->first();

    $this->profile_url = $candidateProfile->profile_url;
    $this->bio = $candidateProfile->bio;
    $this->catch_phrase = $candidateProfile->catch_phrase;
    $this->contact = $candidateProfile->contact;
});

//TODO: implement Google Cloud Natural Language API: (Paid with free tier)
//TODO: Classify.io: (Freemium plan with limitations)
$updateApplication = function () {
    if ($this->upload_profile) {
        $this->rules([
            'upload_profile' => 'required|image',
            'bio' => 'required|string|min:10',
            'catch_phrase' => 'required|string|min:5',
            'contact' => 'required|string|min:10|max:10',
        ])
            ->messages([
                'upload_profile.required' => 'The :attribute can not be empty.',
            ])
            ->attributes([
                'upload_profile' => 'profile picture',
            ]);

        $this->validate();
    }

    $this->validate($this->validationRules());

    $this->updateCandidateProfile();

    return redirect()->intended($this->redirect_url);
};

$validationRules = function () {
    return [
        'bio' => 'required|string|min:10',
        'catch_phrase' => 'required|string|min:5',
        'contact' => 'required|string|min:10|max:10',
    ];
};

$allValidationRules = function () {
    return [
        'upload_profile' => 'required|image',
        'bio' => 'required|string|min:10',
        'catch_phrase' => 'required|string|min:5',
        'contact' => 'required|string|min:10|max:10',
    ];
};

$updateCandidateProfile = function () {
    if ($this->upload_profile && $this->upload_profile->temporaryUrl()) {
        // Delete the old image
        Storage::delete($this->profile_url);

        $this->profile_url = $this->upload_profile->store('SRC');
    }

    CandidateProfile::where('student_id', $this->user->student_id)->update([
        'profile_url' => $this->profile_url,
        'bio' => $this->bio,
        'catch_phrase' => $this->catch_phrase,
        'contact' => $this->contact,
    ]);
};

?>

<div class="min-h-screen flex justify-center items-center">
    <x-form wire:submit.prevent='updateApplication' enctype="multipart/form-data" class="w-2/3 ">

        <div class="w-full flex  justify-between items-center gap-6" x-data="{ showDBImg: true, uploadedImg: '', showLabel: false }">
            <div class="basis-2/5">
                <div class="w-full flex flex-col justify-center items-center">

                    {{-- //TODO: IMPLEMENT HOVER EFFECT TO CHANGE UPLOADED PROFILE PICTURE --}}
                    <div class="relative" @mouseover=" showLabel = true", @mouseout=" showLabel = false">
                        <div class="size-48 rounded-full overflow-hidden mb-3 shadow cursor-pointer group">
                            <img x-show="showDBImg" src="{{ asset('/storage/' . $this->profile_url) }}"
                                alt="no-profile-img"
                                class="s-full group-hover:opacity-0 transition duration-300 ease-in-out" />
                            <img x-show="!showDBImg" :src="uploadedImg" alt="no-uploaded-img"
                                class="s-full object-cover object-top" />
                        </div>

                        <label for="upload_profile"
                            class="absolute inset-0 size-48 overflow-hidden flex justify-center items-center bg-orange-500 cursor-pointer shadow rounded-full transition duration-300 ease-in-out"
                            :class="{ 'opacity-0': !showLabel, 'opacity-100': showLabel }">

                            <x-icon name="o-camera" class="w-7 h-7 text-white" />
                        </label>


                    </div>

                    <h1 class="font-medium mt-2">Profile Picture</h1>

                    <input type="file" id="upload_profile" wire:model="upload_profile" class="hidden"
                        accept="image/*"
                        @change=" showDBImg = false, uploadedImg = URL.createObjectURL($event.target.files[0])" />

                    @error('upload_profile')
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
