<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Login
Volt::route("/login", 'login')->name('login');


Route::middleware('auth')->group(function () {
    //entry-point
    Volt::route("/", 'index');

    //applicant routes
    Volt::route("/apply", 'apply');
    Volt::route("/edit-application", 'edit-application');

    //candidate routes
    Volt::route("/onboard-candidate", "onboard-candidate");
    Volt::route("/update-candidate-profile", "edit-candidate-profile");
});
