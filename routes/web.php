<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JobCategoryController;
use App\Http\Controllers\JobVacancyController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\DashboardController;


// share routes
Route::middleware(['auth', 'role:admin,company-owner'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Job Vacancies
    Route::resource('job-vacancies', JobVacancyController::class, );
    Route::put('job-vacancies/{id}/restore', [JobVacancyController::class, 'restore'])->name('job-vacancies.restore');

    // Job Applications
    Route::resource('job-applications', JobApplicationController::class);
    Route::put('job-applications/{id}/restore', [JobApplicationController::class, 'restore'])->name('job-applications.restore');
});

// company routes
Route::middleware(['auth', 'role:company-owner'])->group(function () {
    Route::get('my-company', [CompanyController::class, 'show'])->name('my-company.show');
    Route::get('my-company/edit', [CompanyController::class, 'edit'])->name('my-company.edit');
    Route::put('my-company', [CompanyController::class, 'update'])->name('my-company.update');
});

// admin routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Job categories
    Route::resource('job-categories', JobCategoryController::class);
    Route::put('job-categories/{id}/restore', [JobCategoryController::class, 'restore'])->name('job-categories.restore');

    // Companies
    Route::resource('companies', CompanyController::class);
    Route::put('companies/{id}/restore', [CompanyController::class, 'restore'])->name('companies.restore');

    // Users
    Route::resource('users', UserController::class);
    Route::put('users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
});


require __DIR__ . '/auth.php';
