<?php

use App\Models\SrcPost;
use App\Models\Applicant;
use Illuminate\Support\Facades\Storage;
use function Livewire\Volt\{state, mount, computed, rules, usesFileUploads};

usesFileUploads();

state([
    'upload_profile' => null,
    'profile_url' => null,
    'src_post_id' => '',
    'src_post' => '',
    'redirect_url' => '/',
]);

$user = computed(fn() => Auth::user());
$votingPosts = computed(fn() => SrcPost::whereNot('src_post_id', 'VP')->get());

mount(function () {
    $application = Applicant::where('student_id', $this->user->student_id)->first();
    $this->profile_url = $application->profile_url;
    $this->src_post_id = $application->src_post_id;
    $this->src_post = SrcPost::where('src_post_id', $this->src_post_id)->first();
});

rules(['upload_profile' => 'required|image', 'src_post_id' => 'required|string|min:3'])
    ->messages([
        'upload_profile.required' => 'The :attribute can not be empty.',
        'src_post_id.required' => 'The :attribute can not be empty.',
    ])
    ->attributes([
        'upload_profile' => 'profile picture',
        'src_post_id' => 'SRC post',
    ]);

$updateApplication = function () {
    if ($this->upload_profile && $this->upload_profile->temporaryUrl()) {
        $this->validate();

        Applicant::where('student_id', $this->user->student_id)->update([
            'src_post_id' => $this->src_post_id,
            'profile_url' => $this->upload_profile->store('SRC'),
        ]);
    } else {
        Applicant::where('student_id', $this->user->student_id)->update([
            'src_post_id' => $this->src_post_id,
        ]);
    }
    //Toast message
    //redirect home
    return redirect()->intended($this->redirect_url);
};

?>

<div class="min-h-screen flex justify-center items-center" x-data="{ showDefaultImg: true, uploadedImg: '', showSRCPost: true }">
    <x-form wire:submit.prevent='updateApplication' enctype="multipart/form-data" class="w-96">

        <div class="w-full flex justify-center">
            <div class="size-44 rounded-full overflow-hidden mb-3 ">
                <img x-show="showDefaultImg" src="{{ asset('/storage/' . $this->profile_url) }}" alt="no-profile-img"
                    class="s-full" />
                <img x-show="!showDefaultImg" :src="uploadedImg" alt="no-uploaded-img"
                    class="s-full object-cover object-top" />
            </div>

        </div>

        <div class="mb-3">
            <label for="upload_profile"
                class="w-full block py-3 text-white text-center cursor-pointer  rounded-lg bg-orange-500">
                Update Image
            </label>
            <input type="file" id="upload_profile" wire:model="upload_profile"
                class="w-full px-4 py-3 mt-2 text-gray-700 border border-gray-300 rounded-md shadow hidden"
                @change=" showDefaultImg = false, uploadedImg = URL.createObjectURL($event.target.files[0])" />
            @error('upload_profile')
                <span class="text-red-400 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <div x-show="showSRCPost" class="mb-3">
            <x-input type="text" label="SRC Post" value="{{ $this->src_post->post }}" readonly
                class="focus:outline-orange-500 focus:border-orange-500 border-orange-500 peer-focus:label:text-orange-500" />
        </div>

        <x-select label="Select new SRC Post" wire:model="src_post_id" :options="$this->votingPosts" option-value="src_post_id"
            option-label="post" class="focus:outline-orange-500 focus:border-orange-500 border-orange-500"
            @change=" showSRCPost = false" />

        <x-slot:actions>
            <x-button label="update" type="submit" spinner="save" class="capitalize bg-orange-600 text-white" />
        </x-slot:actions>
    </x-form>
</div>
