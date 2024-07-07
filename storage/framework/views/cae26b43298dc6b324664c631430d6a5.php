<?php

use Livewire\Volt\Actions;
use Livewire\Volt\CompileContext;
use Livewire\Volt\Contracts\Compiled;
use Livewire\Volt\Component;

new class extends Component implements Livewire\Volt\Contracts\FunctionalComponent
{
    public static CompileContext $__context;

    use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

    public $apply_url;

    public $edit_url;

    public $applicationStatus;

    public function mount()
    {
        (new Actions\InitializeState)->execute(static::$__context, $this, get_defined_vars());

        (new Actions\CallHook('mount'))->execute(static::$__context, $this, get_defined_vars());
    }

    #[\Livewire\Attributes\Computed()]
    public function user()
    {
        $arguments = [static::$__context, $this, func_get_args()];

        return (new Actions\CallMethod('user'))->execute(...$arguments);
    }

    public function editApplication()
    {
        $arguments = [static::$__context, $this, func_get_args()];

        return (new Actions\CallMethod('editApplication'))->execute(...$arguments);
    }

    public function apply()
    {
        $arguments = [static::$__context, $this, func_get_args()];

        return (new Actions\CallMethod('apply'))->execute(...$arguments);
    }

};