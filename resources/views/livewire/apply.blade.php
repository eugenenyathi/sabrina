<?php

use App\Models\SrcPost;
use App\Models\Applicant;
use Illuminate\Support\Facades\Storage;
use function Livewire\Volt\{state, computed, rules, usesFileUploads};

usesFileUploads();

state([
    'no_profile' => 'no-profile.png',
    'profile_img' => null,
    'src_post_id' => '',
    'redirect_url' => '/',
]);

$user = computed(fn() => Auth::user());
$votingPosts = computed(fn() => SrcPost::whereNot('src_post_id', 'VP')->get());

rules(['profile_img' => 'required|image', 'src_post_id' => 'required|string|min:3'])
    ->messages([
        'profile_img.required' => 'The :attribute can not be empty.',
        'src_post_id.required' => 'The :attribute can not be empty.',
    ])
    ->attributes([
        'profile_img' => 'profile picture',
        'src_post_id' => 'SRC post',
    ]);

$apply = function () {
    if ($this->profile_img && $this->profile_img->temporaryUrl()) {
        $this->validate();

        //TODO: Applicant cant be a block student, 1.1, 2.2, 3.1, 3.2, 4.2 can not run for office
        Applicant::create([
            'student_id' => $this->user->student_id,
            'src_post_id' => $this->src_post_id,
            'profile_url' => $this->profile_img->store('SRC'),
        ]);

        //Toast message
        //redirect home

        return redirect()->intended($this->redirect_url);
    } else {
        $this->validate();
    }
};

?>

<div class="min-h-screen flex justify-center items-center" x-data="{ showDefaultImg: true, uploadedImg: '' }">
    <x-form wire:submit.prevent='apply' enctype="multipart/form-data" class="w-96">
        <div class="w-full flex justify-center">
            <div class="size-44 rounded-full overflow-hidden mb-3 ">
                <img x-show="showDefaultImg" src="{{ asset('no-profile.png') }}" alt="no-profile-img" class="s-full" />
                <img x-show="!showDefaultImg" :src="uploadedImg" alt="no-uploaded-img"
                    class="s-full object-cover object-top" />
            </div>

        </div>
        <div class="mb-3">
            <label for="profile_img"
                class="w-full block py-3 text-white text-center cursor-pointer  rounded-lg bg-orange-500">
                Select Image
            </label>
            <input type="file" id="profile_img" wire:model="profile_img"
                class="w-full px-4 py-3 mt-2 text-gray-700 border border-gray-300 rounded-md shadow hidden"
                @change=" showDefaultImg = false, uploadedImg = URL.createObjectURL($event.target.files[0])" />
            @error('profile_img')
                <span class="text-red-400 text-xs">{{ $message }}</span>
            @enderror
        </div>
        <x-select label="SRC Post" wire:model="src_post_id" placeholder="Select a Post" :options="$this->votingPosts"
            option-value="src_post_id" option-label="post"
            class="focus:outline-orange-500 focus:border-orange-500 border-orange-500" />
        <x-slot:actions>
            <x-button label="apply" type="submit" icon="o-paper-airplane" spinner="save"
                class="capitalize bg-orange-600 text-white" />
        </x-slot:actions>
    </x-form>
</div>
