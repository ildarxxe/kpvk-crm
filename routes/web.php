<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicPagesController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskStatusController;
use App\Http\Middleware\CheckProfileMiddleware;
use Illuminate\Support\Facades\Route;

Route::get("/other/1", function() {
    return view('other.draft1');
});

Route::get('/', [PublicPagesController::class, 'home'])->name('public.home');
Route::get('/about-system', [PublicPagesController::class, 'about'])->name('public.about');
Route::get('/help/what-is-chaincrm', [PublicPagesController::class, 'helpWhatIs'])->name('public.help.what_is_chaincrm');
Route::get('/sitemap.xml', [PublicPagesController::class, 'sitemap'])->name('public.sitemap');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, "showLogin"])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('loginPost');
});

Route::get("/respond/{token}", [SupportController::class, "viewRespond"])->name('respond');

Route::middleware(['auth', CheckProfileMiddleware::class])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/export', [TaskController::class, 'viewExport']);
    Route::get('/profile/{user_id}', [ProfileController::class, 'viewUserProfile']);
    Route::get('/profile', [ProfileController::class, 'viewProfile'])->name('profile');
    Route::post('/export/generate', [TaskController::class, 'generate'])->name('generate');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::put('/change-password', [ProfileController::class, 'changePassword'])->name('changePassword');
    Route::put('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');

    Route::get("/support", [SupportController::class, "viewSupport"])->name('support');
    Route::post("/support", [SupportController::class, "support"])->name('support.send');

    Route::get("/notifications", [NotificationController::class, "viewNotifications"])->name('notifications');
    Route::post("/notifications/mark-as-read", [NotificationController::class, "markAllAsRead"])->name('notifications.markAsRead');
    Route::post("/notifications/{support}", [NotificationController::class, "respond"])->name('notifications.respond');

    Route::get('/complete-profile', [ProfileController::class, 'viewCompleteProfile'])->name('complete-profile');
    Route::post('/complete-profile', [ProfileController::class, 'completeProfile'])->name('profile.complete.store');

    Route::prefix("tasks")->group(function () {
        Route::get('/', [TaskController::class, 'viewCreate'])->name('tasks.viewCreate');
        Route::post('/', [TaskController::class, 'create'])->name('tasks.create');
        Route::delete("/{task}", [TaskController::class, 'delete'])->name('tasks.delete');

        Route::patch('/{id}/approve', [TaskStatusController::class, 'approve'])->name('tasks.approve');
        Route::patch('/{id}/complete', [TaskStatusController::class, 'complete'])->name('tasks.complete');
        Route::patch('/{id}/decline', [TaskStatusController::class, 'decline'])->name('tasks.decline');

        Route::post('/{task}/rate', [ReviewController::class, 'rate']);

        Route::get('/{id}', [TaskController::class, 'showTaskDetails']);
    });
});
