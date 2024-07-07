<?php

use App\Models\Student;
use App\Models\Candidate;
use App\Constants\Profiles;
use App\Models\CandidateProfile;
use Illuminate\Support\Facades\Auth;

?>

<div class="fixed top-0 left-0 right-0 z-50 bg-white border-b-2 border-b-scarlet">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center py-3">
            <h2 class="font-custom text-4xl bg-gradient-to-r from-amber-500 to-pink-500 bg-clip-text text-transparent">
                Sabrina
            </h2>
            <?php if (isset($component)) { $__componentOriginaldee4e996545a5da8b3c30122654040cc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldee4e996545a5da8b3c30122654040cc = $attributes; } ?>
<?php $component = Mary\View\Components\Avatar::resolve(['image' => ''.e(asset('/storage/' . $this->profile_url)).'','title' => ''.e($this->fullName).''] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('avatar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Mary\View\Components\Avatar::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => '!w-11']); ?>
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
    </div>
</div><?php /**PATH C:\Users\eugen\Documents\Workspace\sabrina-live\resources\views\livewire/header.blade.php ENDPATH**/ ?>