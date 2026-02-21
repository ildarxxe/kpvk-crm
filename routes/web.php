<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskStatusController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, "showLogin"])->name('login');
    //Route::get('/register', [AuthController::class, "showRegister"]);

    Route::post('/login', [AuthController::class, 'login'])->name('loginPost');
    //Route::post('/register', [AuthController::class, 'register'])->name("register");
});

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/export', [TaskController::class, 'viewExport']);
    Route::get('/profile/{user_id}', [ProfileController::class, 'viewUserProfile']);
    Route::get('/profile', [ProfileController::class, 'viewProfile'])->name('profile');
    Route::post('/export/generate', [TaskController::class, 'generate'])->name('generate');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::put('/change-password', [ProfileController::class, 'changePassword'])->name('changePassword');
    Route::put('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');

    
    Route::get('/complete-profile', [ProfileController::class, 'viewCompleteProfile'])->name('complete-profile');
    Route::post('/complete-profile', [ProfileController::class, 'completeProfile'])->name('profile.complete.store');

    Route::prefix("tasks")->group(function () {
        Route::get('/', [TaskController::class, 'viewCreate'])->name('tasks.viewCreate');
        Route::post('/', [TaskController::class, 'create'])->name('tasks.create');

        Route::patch('/{id}/approve', [TaskStatusController::class, 'approve'])->name('tasks.approve');
        Route::patch('/{id}/complete', [TaskStatusController::class, 'complete'])->name('tasks.complete');
        Route::patch('/{id}/decline', [TaskStatusController::class, 'decline'])->name('tasks.decline');

        Route::post('/{task}/rate', [ReviewController::class, 'rate']);

        Route::get('/{id}', [TaskController::class, 'showTaskDetails']);

    });
});
