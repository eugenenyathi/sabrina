<?php

use App\Models\SrcPost;
use App\Models\Student;
use App\Models\PortalStatus;
use Illuminate\Support\Facades\Auth;
use App\Constants\PortalStatusConstants;

?>

<div class="m-h-screen w-full bg-neutral-50">

    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('header', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-2473857540-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>

    <div class="relative top-28
        w-full z-10">

        <!--[if BLOCK]><![endif]--><?php if($this->portalStatus == PortalStatusConstants::VOTING): ?>
            <div class="absolute left-52 w-[482px]">
                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('voting-alert', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-2473857540-1', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('votingcards', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-2473857540-2', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
            </div>

            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('votingposts', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-2473857540-3', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
        <?php else: ?>
            <div class="absolute left-80 w-[482px]">
                <!--[if BLOCK]><![endif]--><?php switch($this->portalStatus):
                    case (PortalStatusConstants::APPLICATION): ?>
                        
                        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('apply-alert', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-2473857540-4', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('studentcouncil', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-2473857540-5', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                    <?php break; ?>

                    <?php case (PortalStatusConstants::CANDIDATE_ONBOARDING): ?>
                        
                        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('onboarding-alert', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-2473857540-6', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('candidatecards', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-2473857540-7', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                    <?php break; ?>

                    <?php default: ?>
                        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('studentcouncil', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-2473857540-8', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                <?php endswitch; ?><!--[if ENDBLOCK]><![endif]-->

            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    </div>

</div><?php /**PATH C:\Users\eugen\Documents\Workspace\sabrina\resources\views\livewire/index.blade.php ENDPATH**/ ?>