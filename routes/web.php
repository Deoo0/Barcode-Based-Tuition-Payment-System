<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentController as StudentDetailsController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Admin\DashboardController;

Route::get('/', function () {
    return view('login');
})->name('login'); // important

Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout']);
Route::get('/forgotpw',fn() => view('forgotpw'))->name('forgotpw');

Route::middleware(['auth'])->group(function () {
    Route::get('/home', fn() => view('home'))->name('home');
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');
    Route::get('/payment', fn() => view('payment'))->name('payment');
    Route::get('/transactions', [TransactionController::class,'index'])->name('transactions');
    Route::get('/statistics', fn() => view('stat'))->name('statistics');
    Route::get('/users', [UserController::class, 'index'])->name('users')->middleware(\App\Http\Middleware\IsAdmin::class);
    Route::post('/register',[UserController::class,'register'])->name('register')->middleware(\App\Http\Middleware\IsAdmin::class);
    Route::delete('/delete/{user}',[UserController::class,'deleteUser'])->middleware(\App\Http\Middleware\IsAdmin::class);
    Route::delete('/delete/student/{student}',[StudentController::class,'deleteStudent']);
    Route::get('/students',[StudentController::class,'index'])->name('students');
    Route::get('/students/{student}/details', [StudentController::class, 'details'])->name('students.details');
    Route::post('/addStudent',[StudentController::class,'addUser'])->name('addUser');
    // AJAX endpoint for dynamic edit modal
    Route::get('/users/{user}/edit-modal', [UserController::class, 'editModal'])->middleware(\App\Http\Middleware\IsAdmin::class);
    Route::get('/students/{student}/edit-modal',[StudentController::class , 'editStudent'])->middleware(App\Http\Middleware\IsAdmin::class);
    Route::put('/edit-user/{id}',[UserController::class,'updateUserInfo'])->middleware(\App\Http\Middleware\IsAdmin::class);
    Route::put('/edit-student/{id}',[StudentController::class, 'updateStudentInfo'])->middleware(App\Http\Middleware\IsAdmin::class);
    Route::get('/scan', [StudentController::class, 'scan'])->name('scan');
    Route::get('/payment-info',[StudentController::class, 'paymentInfo'])->name('payment-info');
    Route::post('/process-payment', [PaymentController::class, 'payment'])->name('process-payment');
    Route::get('/students/search', [StudentController::class, 'search'])->name('students.search');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
