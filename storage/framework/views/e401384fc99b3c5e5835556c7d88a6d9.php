<?php

use App\Http\Services\SRCService;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\CandidateService;
use App\Constants\PortalStatusConstants;

?>

<div>
    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $this->records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="w-full mb-4 rounded-md bg-white border border-neutral-200 ">

            <div class="p-3">
                <?php if (isset($component)) { $__componentOriginaldee4e996545a5da8b3c30122654040cc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldee4e996545a5da8b3c30122654040cc = $attributes; } ?>
<?php $component = Mary\View\Components\Avatar::resolve(['image' => ''.e(asset('/storage/' . $record->profile_url)).'','title' => ''.e($record->fullName).'','subtitle' => ''.e($record->program).' - Part '.e($record->part).''] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('avatar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Mary\View\Components\Avatar::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => '!w-11 cursor-pointer']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldee4e996545a5da8b3c30122654040cc)): ?>
<?php $attributes = $__attributesOriginaldee4e996545a5da8b3c30122654040cc; ?>
<?php unset($__attributesOriginaldee4e996545a5da8b3c30122654040cc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldee4e996545a5da8b3c30122654040cc)): ?>
<?php $component = $__componentOriginaldee4e996545a5da8b3c30122654040cc; ?>
<?php unset($__componentOriginaldee4e996545a5da8b3c30122654040cc); ?>
<?php endif; ?>
            </div>

            
            <div>
                <img src="<?php echo e(asset('/storage/' . $record->profile_url)); ?>" alt="<?php echo e($record->fullName); ?>"
                    class="w-full max-h-96 object-cover object-top">
            </div>


            <div class="p-3 ">
                <!--[if BLOCK]><![endif]--><?php if($this->studentIsACandidate): ?>
                    <p class="mb-3 text-sm font-medium"><?php echo e($record->catch_phrase); ?></p>
                <?php else: ?>
                    <div class="flex items-center gap-2">
                        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('bi-phone'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(BladeUI\Icons\Components\Svg::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-6 h-6 cursor-pointer']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                        <p class="mb-3 text-sm font-medium"><?php echo e($record->contact); ?></p>
                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>

        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
</div><?php /**PATH C:\Users\eugen\Documents\Workspace\sabrina\resources\views\livewire/candidatecards.blade.php ENDPATH**/ ?>