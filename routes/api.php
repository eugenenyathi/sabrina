<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\BirdsViewController;
use App\Http\Controllers\VotesController;
use App\Http\Controllers\VotingResultsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/test', [TestController::class, 'init']);

Route::get('/applicants', [BirdsViewController::class, 'applicants']);
Route::get('/candidates', [BirdsViewController::class, 'candidates']);
Route::get('/voters', [BirdsViewController::class, 'voters']);

Route::get('/approve_applicants', [ApplicantController::class, 'init']);
Route::get('/vote', [VotesController::class, 'vote__']);
Route::get('/count_votes', [VotingResultsController::class, 'countVotes__']);
