<?php

use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use function Livewire\Volt\{state, rules};

state([
    'student_id' => '',
    'password' => '',
    'redirect_url' => '/',
]);

rules(
    fn () => [
        'student_id' => ['required', 'string', 'max:9', 'regex: /^L0\d{6}[A-Z]{1}$/u'],
        'password' => ['required', 'string', 'min:8'],
    ],
);

$login = function () {
    $this->validate();

    $user = User::where('student_id', $this->student_id)->first();

    Auth::login($user);

    request()->session()->regenerate();

    return redirect()->intended($this->redirect_url);
};

?>

<div class="h-screen flex justify-center items-center">
    <div class="w-96">
        <img src="{{ asset('lupane.png') }}" alt="lsu logo" width="260" class="mb-7 mx-auto">
        <x-form wire:submit.prevent="login">
            <x-input wire:model='student_id' placeholder="Student Number" icon="o-user" class="focus:outline-orange-500 focus:border-orange-500 border-orange-500 peer-focus:label:text-orange-500" />
            <x-input wire:model='password' placeholder="Password" type="password" icon="o-key" class="focus:outline-orange-500 focus:border-orange-500 border-orange-500" />
            <x-slot:actions>
                <x-button label="Login" type="submit" icon="o-paper-airplane" class=" bg-orange-600 text-white" spinner="login" />
            </x-slot:actions>
        </x-form>
    </div>
</div>