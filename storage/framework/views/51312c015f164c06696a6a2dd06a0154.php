<?php

use Livewire\Volt\Actions;
use Livewire\Volt\CompileContext;
use Livewire\Volt\Contracts\Compiled;
use Livewire\Volt\Component;

new class extends Component implements Livewire\Volt\Contracts\FunctionalComponent
{
    public static CompileContext $__context;

    use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

    use Livewire\WithFileUploads;

    public $upload_profile;

    public $profile_url;

    public $bio;

    public $catch_phrase;

    public $contact;

    public $redirect_url;

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

    public function updateApplication()
    {
        $arguments = [static::$__context, $this, func_get_args()];

        return (new Actions\CallMethod('updateApplication'))->execute(...$arguments);
    }

    public function validationRules()
    {
        $arguments = [static::$__context, $this, func_get_args()];

        return (new Actions\CallMethod('validationRules'))->execute(...$arguments);
    }

    public function allValidationRules()
    {
        $arguments = [static::$__context, $this, func_get_args()];

        return (new Actions\CallMethod('allValidationRules'))->execute(...$arguments);
    }

    public function updateCandidateProfile()
    {
        $arguments = [static::$__context, $this, func_get_args()];

        return (new Actions\CallMethod('updateCandidateProfile'))->execute(...$arguments);
    }

};