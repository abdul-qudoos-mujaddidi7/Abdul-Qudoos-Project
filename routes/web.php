<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use App\Jobs\TranslateJob;
use App\Mail\JobPosted;
use App\Models\Job;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

use function Pest\Laravel\delete;

Route::view('home', 'home');
Route::view('/contact', 'contact');

Route::get("");

Route::get('test',function(){

    $job=Job::first();
    TranslateJob::dispatch($job);
});


// Route::controller(JobController::class)->group(function () {
//     Route::get('/jobs', 'index')->name('jobs.index');
//     Route::get('/jobs/create', 'create')->name('jobs.create');
//     Route::post('/jobs', 'store')->name('jobs.store');
//     Route::get('/jobs/{job}', 'show')->name('jobs.show');
//     Route::get('/jobs/{job}/edit', 'edit')->name('jobs.edit');
//     Route::put('/jobs/{job}', 'update')->name('jobs.update');
//     Route::delete('/jobs/{job}', 'destroy')->name('jobs.destroy');
// });

// Route::resource('jobs', JobController::class);

Route::middleware('auth')->group(function () {
    Route::get('/jobs', [JobController::class, 'index']);
    Route::get('/jobs/create', [JobController::class, 'create']);
    Route::get('jobs/{job}', [JobController::class, 'show']);
    Route::patch('/jobs/{job}', [JobController::class, 'update']);
    Route::delete('/jobs/{job}', [JobController::class, 'destroy']);
});
Route::post('/jobs', [JobController::class, 'store']);
Route::get('/jobs/{job}/edit', [JobController::class, 'edit']) ->middleware('auth')->can('edit','job');


// Auth
Route::get('/register',[RegisteredUserController::class,'create']);
Route::post('/registered', [RegisteredUserController::class, 'store']);

Route::get('/',[SessionController::class,'create'])->name('login');
Route::post('/login',[SessionController::class,'store']);
Route::post('/logout',[SessionController::class,'destroy']);
