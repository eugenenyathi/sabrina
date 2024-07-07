<?php

use Livewire\Volt\Actions;
use Livewire\Volt\CompileContext;
use Livewire\Volt\Contracts\Compiled;
use Livewire\Volt\Component;

new class extends Component implements Livewire\Volt\Contracts\FunctionalComponent
{
    public static CompileContext $__context;

    use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

    public $candidates;

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

    public function vote($candidateId)
    {
        $arguments = [static::$__context, $this, func_get_args()];

        return (new Actions\CallMethod('vote'))->execute(...$arguments);
    }

    public function removeVote($candidateId)
    {
        $arguments = [static::$__context, $this, func_get_args()];

        return (new Actions\CallMethod('removeVote'))->execute(...$arguments);
    }

    public function voteStatus($candidate)
    {
        $arguments = [static::$__context, $this, func_get_args()];

        return (new Actions\CallMethod('voteStatus'))->execute(...$arguments);
    }

    public function getListeners()
    {
        $arguments = [static::$__context, $this, func_get_args()];

        return (new Actions\ResolveListeners)->execute(...$arguments);
    }

    public function votingpostUpdatedHandler($src_post_id)
    {
        $arguments = [static::$__context, $this, func_get_args()];

        return (new Actions\CallListener('votingpost-updated'))->execute(...$arguments);
    }

};