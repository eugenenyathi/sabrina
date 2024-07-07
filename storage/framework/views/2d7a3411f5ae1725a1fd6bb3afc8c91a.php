<?php

use App\Models\SrcPost;
use App\Constants\SrcPostConstants;

?>

<div class="fixed right-52 w-[340px] rounded-md p-4 border border-neutral-200">
    <div class="w-full flex justify-between items-center">
        <h1 class="font-bold mb-2 text-lg text-scarlet">Voting Posts</h1>
        <?php if (isset($component)) { $__componentOriginalce0070e6ae017cca68172d0230e44821 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce0070e6ae017cca68172d0230e44821 = $attributes; } ?>
<?php $component = Mary\View\Components\Icon::resolve(['name' => 'o-chevron-right'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Mary\View\Components\Icon::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'size-7 text-gray-500 cursor-pointer hover:text-scarlet focus:text-scarlet','wire:click' => 'loadMorePosts']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce0070e6ae017cca68172d0230e44821)): ?>
<?php $attributes = $__attributesOriginalce0070e6ae017cca68172d0230e44821; ?>
<?php unset($__attributesOriginalce0070e6ae017cca68172d0230e44821); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce0070e6ae017cca68172d0230e44821)): ?>
<?php $component = $__componentOriginalce0070e6ae017cca68172d0230e44821; ?>
<?php unset($__componentOriginalce0070e6ae017cca68172d0230e44821); ?>
<?php endif; ?>
    </div>
    <ul class="divide-y">
        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $this->votingPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $votingPost): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <!--[if BLOCK]><![endif]--><?php if($votingPost->src_post_id === $this->active_post): ?>
                <li class="text-base font-bold py-3 cursor-pointer flex items-center gap-2"
                    wire:click.live="activeVotingPost(<?php echo e($votingPost->src_post_id); ?>)">
                    
                    <p><?php echo e($votingPost->post); ?></p>
                </li>
            <?php else: ?>
                <li class="text-base py-3 cursor-pointer  flex items-center gap-2"
                    wire:click.live="activeVotingPost(<?php echo e($votingPost); ?>)">
                    
                    <p><?php echo e($votingPost->post); ?></p>
                </li>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
    </ul>
</div><?php /**PATH C:\Users\eugen\Documents\Workspace\sabrina\resources\views\livewire/votingposts.blade.php ENDPATH**/ ?>