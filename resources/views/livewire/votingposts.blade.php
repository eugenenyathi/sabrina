<?php

use App\Models\SrcPost;
use App\Constants\SrcPostConstants;
use function Livewire\Volt\{state, mount, computed};

state([
    'active_post' => SrcPostConstants::PRESIDENT['src_post_id'],
    'votingPosts' => [],
    'currentPage' => 1,
]);

mount(function () {
    $this->votingPosts = $this->getPaginatedPosts();
});

$activeVotingPost = function (SrcPost $post) {
    $this->active_post = $post->src_post_id;
    $this->dispatch('votingpost-updated', $post->src_post_id);
};

$loadMorePosts = function () {
    switch ($this->currentPage) {
        case 1:
            $this->currentPage += 1;
            $this->votingPosts = $this->getPaginatedPosts($this->currentPage);
            break;

        default:
            $this->currentPage = 1;
            $this->active_post = SrcPostConstants::PRESIDENT['src_post_id'];
            $this->votingPosts = $this->getPaginatedPosts($this->currentPage);
            break;
    }
};

$getPaginatedPosts = function ($currentPage = 1) {
    // Fetch filtered posts from the model
    $vposts = SrcPost::whereNot('src_post_id', SrcPostConstants::VP['src_post_id'])->get();
    $vposts = $vposts->all();

    $itemsPerPage = 5;

    // Validate and sanitize input
    $currentPage = (int) max($currentPage, 1); // Ensure positive page number
    $itemsPerPage = (int) max($itemsPerPage, 1); // Ensure positive items per page

    // Calculate total number of pages
    $totalPages = ceil(count($vposts) / $itemsPerPage);

    // Validate requested page (don't exceed total pages)
    $currentPage = min($currentPage, $totalPages);

    // Calculate starting index based on current page and items per page
    $startIndex = ($currentPage - 1) * $itemsPerPage;

    // Ensure `$startIndex` is never negative, especially when calculating for the first page
    $startIndex = max($startIndex, 0); // Set minimum `startIndex` to 0

    // Slice the data using array_slice with proper checks
    $paginatedPosts = array_slice($vposts, $startIndex, min($startIndex + $itemsPerPage, count($vposts) - 1));

    return $paginatedPosts;
};

?>

<div class="fixed right-52 w-[340px] rounded-md p-4 border border-neutral-200">
    <div class="w-full flex justify-between items-center">
        <h1 class="font-bold mb-2 text-lg text-scarlet">Voting Posts</h1>
        <x-icon name="o-chevron-right" class="size-7 text-gray-500 cursor-pointer hover:text-scarlet focus:text-scarlet"
            wire:click='loadMorePosts' />
    </div>
    <ul class="divide-y">
        @foreach ($this->votingPosts as $votingPost)
            @if ($votingPost->src_post_id === $this->active_post)
                <li class="text-base font-bold py-3 cursor-pointer flex items-center gap-2"
                    wire:click.live="activeVotingPost({{ $votingPost->src_post_id }})">
                    {{-- <x-icon name="{{ $votingPost['icon'] }}" class="size-7 text-scarlet" /> --}}
                    <p>{{ $votingPost->post }}</p>
                </li>
            @else
                <li class="text-base py-3 cursor-pointer  flex items-center gap-2"
                    wire:click.live="activeVotingPost({{ $votingPost }})">
                    {{-- <x-icon name="{{ $votingPost['icon'] }}" class="size-7 text-scarlet" /> --}}
                    <p>{{ $votingPost->post }}</p>
                </li>
            @endif
        @endforeach
    </ul>
</div>
