<div>
    <!-- STANDARD LABEL -->
    <!--[if BLOCK]><![endif]--><?php if($label && !$inline): ?>
        <label for="<?php echo e($uuid); ?>" class="pt-0 label label-text font-semibold">
            <span>
                <?php echo e($label); ?>


                <!--[if BLOCK]><![endif]--><?php if($attributes->get('required')): ?>
                    <span class="text-error">*</span>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </span>
        </label>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <div class="flex-1 relative">
        <!-- INPUT -->
        <textarea
            placeholder = "<?php echo e($attributes->whereStartsWith('placeholder')->first()); ?> "

            <?php echo e($attributes
                ->class([
                    'textarea textarea-primary w-full peer',
                    'pt-5' => ($inline && $label),
                    'border border-dashed' => $attributes->has('readonly') && $attributes->get('readonly') == true,
                    'textarea-error' => $errors->has($errorFieldName())
                ])); ?>

        ><?php echo e($slot); ?></textarea>

        <!-- INLINE LABEL -->
        <!--[if BLOCK]><![endif]--><?php if($label && $inline): ?>
            <label for="<?php echo e($uuid); ?>" class="absolute text-gray-400 duration-300 transform -translate-y-3 scale-75 top-4 bg-white rounded dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2  peer-focus:scale-75 peer-focus:-translate-y-3 left-2">
                <?php echo e($label); ?>

            </label>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>

    <!-- ERROR -->
    <!--[if BLOCK]><![endif]--><?php if(!$omitError && $errors->has($errorFieldName())): ?>
        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $errors->get($errorFieldName()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = Arr::wrap($message); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $line): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="<?php echo e($errorClass); ?>" x-classes="text-red-500 label-text-alt p-1"><?php echo e($line); ?></div>
                <?php if($firstErrorOnly) break; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            <?php if($firstErrorOnly) break; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!-- HINT -->
    <!--[if BLOCK]><![endif]--><?php if($hint): ?>
        <div class="label-text-alt text-gray-400 p-1 pb-0"><?php echo e($hint); ?></div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div><?php /**PATH C:\Users\eugen\Documents\Workspace\sabrina\storage\framework\views/8f60c9c8fbf17e3353a47a8ad5fcb3d9.blade.php ENDPATH**/ ?>