<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\jobsController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/jobs', [jobsController::class, 'index'])->name('jobs');




Route::group(['prefix' => 'Account'], function () {

    // guest routes
    Route::group(['middleware' => 'guest'], function () {
        Route::get('/register', [AccountController::class, 'registration'])->name('account.registration');
        Route::post('/process-register', [AccountController::class, 'saveRegestration'])->name('account.process-registration');
        Route::get('/login', [AccountController::class, 'login'])->name('account.login');
        Route::post('/authenticate', [AccountController::class, 'authenticate'])->name('account.authenticate');
    });


    // authenticated routes
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/profile', [AccountController::class, 'profile'])->name('account.profile');
        Route::put('/upadteprofile', [AccountController::class, 'updateProfile'])->name('account.upadteprofile');
        Route::get('/logout', [AccountController::class, 'logout'])->name('account.logout');

        Route::post('/update-profile-picture', [AccountController::class, 'updateProfilePicture'])->name('account.updateProfilePicture');
        Route::get('/create-job', [AccountController::class, 'createJob'])->name('account.createJob');
        Route::post('/save-job', [AccountController::class, 'saveJob'])->name('account.saveJob');
        Route::get('/My-job', [AccountController::class, 'MyJobs'])->name('account.MyJobs');
        Route::get('/My-job/edit/{jobId}', [AccountController::class, 'editJob'])->name('account.EditJob');
        Route::post('/update-job/{jobId}', [AccountController::class, 'UpdateJob'])->name('account.UpdateJob');

        Route::get('/delete-job/{jobId}', [AccountController::class, 'deleteJob'])->name('account.deleteJob');

    });



});
Route::fallback(function () {

    return view("fallbackPage");
});
