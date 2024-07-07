<div class="flex items-center gap-2">
    <div class="avatar">
        <div <?php echo e($attributes->class(["w-7 rounded-full"])); ?>>
            <img src="<?php echo e($image); ?>" />
        </div>
    </div>
    <!--[if BLOCK]><![endif]--><?php if($title || $subtitle): ?>
    <div>
        <!--[if BLOCK]><![endif]--><?php if($title): ?>
            <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(["font-semibold font-lg", is_string($title) ? '' : $title?->attributes->get('class') ]); ?>" >
                <?php echo e($title); ?>

            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        <!--[if BLOCK]><![endif]--><?php if($subtitle): ?>
            <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(["text-sm text-gray-400", is_string($subtitle) ? '' : $subtitle?->attributes->get('class') ]); ?>" >
                <?php echo e($subtitle); ?>

            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div><?php /**PATH C:\Users\eugen\Documents\Workspace\sabrina\storage\framework\views/87bb448014c4fe565b10f8d8e01e976f.blade.php ENDPATH**/ ?>