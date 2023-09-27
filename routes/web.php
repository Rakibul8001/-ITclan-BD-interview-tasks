<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IdeaController;
use App\Http\Controllers\TournamentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//ideas routes
Route::middleware(['auth'])->group(function () {
    Route::get('/ideas', [IdeaController::class,'index'])->name('ideas.index');
    Route::get('/ideas/create', [IdeaController::class, 'create'])->name('ideas.create');
    Route::post('/ideas', [IdeaController::class, 'store'])->name('ideas.store');
});

//tournaments routes
Route::post('/tournaments', [TournamentController::class, 'store'])->name('tournaments.store');

//wining phases routes
Route::post('/phase', [TournamentController::class, 'start'])->name('tournaments.start');
Route::post('/phase', [TournamentController::class, 'phaseOne'])->name('tournaments.phaseOne');
Route::post('/phase', [TournamentController::class, 'phaseTwo'])->name('tournaments.phaseTwo');
