<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\JobApplicationController;
use App\Http\Controllers\admin\JobController;
use App\Http\Controllers\admin\UserController;
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



Route::get('/', [HomeController::class, 'index'])->name('home');

// list jobs page

Route::get('/jobs', [jobsController::class, 'index'])->name('jobs');

// job details page

Route::get('/jobs/details/{id}', [jobsController::class, 'details'])->name('jobDetails');

// applyJob

Route::post('/applyJob', [jobsController::class, 'applyJob'])->name('applyJob');

// saveJob

Route::post('/saveJob', [jobsController::class, 'saveJob'])->name('saveJob');

// group for admin url

Route::group(['prefix' => 'admin', 'middleware' => 'checkRole'], function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('adminDashboard');


    Route::get('/users', [UserController::class, 'index'])->name('admin.users.list');


    Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('admin.users.edit');

    Route::put('/users/update/{id}', [UserController::class, 'update'])->name('admin.users.update');


    Route::get('/users/delete/{id}', [UserController::class, 'delete'])->name('admin.users.delete');


    // jobs routes
    Route::get('/jobs', [JobController::class, 'index'])->name('admin.jobs.list');

    Route::get('/jobs/edit/{id}', [JobController::class, 'edit'])->name('admin.jobs.edit');

    Route::put('/jobs/Update/{id}', [JobController::class, 'Update'])->name('admin.jobs.Update');

    Route::get('/jobs/delete/{id}', [JobController::class, 'delete'])->name('admin.jobs.delete');

    // job application routes
    Route::get('/job/applications', [JobApplicationController::class, 'index'])->name('admin.jobs.applications');

    Route::get('/applications/delete/{id}', [JobApplicationController::class, 'delete'])->name('admin.applications.delete');


});


// groupe for account url

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

        //My jobs application
        Route::get('/JobApplications', [AccountController::class, 'MyJobApplication'])->name('account.MyJobApplication');

        Route::get('/DeleteJobApplications/{id}', [AccountController::class, 'deleteJobApplication'])->name('account.deleteJobApplication');

        // My Saved Jobs
        Route::get('/SavedJobs', [AccountController::class, 'SavedJobs'])->name('account.SavedJobs');

        Route::get('/DeleteSavedJobs/{id}', [AccountController::class, 'DeleteSavedJobs'])->name('account.DeleteSavedJobs');

    });





});
Route::fallback(function () {

    return view("fallbackPage");
});
