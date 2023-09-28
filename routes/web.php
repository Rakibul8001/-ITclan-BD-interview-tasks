<?php

use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IdeaController;
use App\Http\Controllers\TournamentController;
use Illuminate\Support\Facades\Auth;

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
    if(Auth::check()){
        return redirect()->route('home');
    }
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//ideas routes
Route::middleware(['auth'])->group(function () {
    Route::get('/ideas', [IdeaController::class,'index'])->name('ideas.index');
    Route::get('/ideas/create', [IdeaController::class, 'create'])->name('ideas.create');
    Route::post('/ideas', [IdeaController::class, 'store'])->name('ideas.store');
    //tournaments routes
    Route::get('/tournament/{id}', [TournamentController::class, 'show'])->name('tournaments.show');
    Route::get('/tournaments', [TournamentController::class, 'index'])->name('tournaments.index');
    Route::post('/tournaments', [TournamentController::class, 'store'])->name('tournaments.store');
});


//test email by mailtrap
Route::get('/send-email',function(){
    $message ='This is for testing email using smtp';

    $recipients =['mdrakibul.islam8001@gmail.com'];
     Mail::to($recipients)->send(new SendEmail($message));

     dd("Email is Sent.");
});


