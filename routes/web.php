<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SystemUserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PerformanceController;
use App\Http\Controllers\AiController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\MLReportController;


// ── Auth routes ───────────────────────────────────────────────────────────────
Auth::routes();

Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'registerForm'])->name('register.form');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register');
Route::post('/change-password', [App\Http\Controllers\Auth\ResetPasswordController::class, 'changePassword'])->name('password.change');

use App\Http\Controllers\ImportedTaskController;

Route::get('/import/tasks',               [ImportedTaskController::class, 'index'])->name('import.index');
Route::post('/import/tasks/upload',       [ImportedTaskController::class, 'upload'])->name('import.upload');
Route::get('/import/tasks/{id}/analysis', [ImportedTaskController::class, 'analysis'])->name('import.analysis');
Route::delete('/import/tasks/{id}',       [ImportedTaskController::class, 'destroy'])->name('import.destroy');
Route::post('/import/tasks/{id}/convert', [ImportedTaskController::class, 'convert'])->name('import.convert');

// ── Root redirect ─────────────────────────────────────────────────────────────
Route::get('/', function () {
    if (Auth::check()) return redirect()->route('home');
    return view('auth.login');
});

Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// ── Notifications ─────────────────────────────────────────────────────────
Route::get('/notifications/list',            [NotificationController::class, 'index'])->name('business.notifications.index');
Route::post('/notifications/mark-all-read',  [HomeController::class, 'markAllAsRead'])->name('notifications.markAllRead');
Route::delete('/notifications/clear-all',    [HomeController::class, 'clearAllNotifications'])->name('notifications.clearAll');
Route::get('/notifications/{id}/read',       [HomeController::class, 'markAsRead'])->name('notifications.read');
Route::delete('/notifications/{id}',         [HomeController::class, 'removeNotification'])->name('notifications.remove');

// ── All authenticated routes ──────────────────────────────────────────────────
Route::middleware(['auth'])->group(function () {

    // ── Audit ──────────────────────────────────────────────────────────────
    Route::get('/audit-log', [AuditLogController::class, 'index'])->name('audit.index');
    Route::get('/audit-log-data', [AuditLogController::class, 'data'])->name('audit.data');
    Route::get('/audit-log-details/{id}', [AuditLogController::class, 'details'])->name('audit.details');

    // ── Dashboard ─────────────────────────────────────────────────────────────
    Route::get('/home',      [HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    // ── Notifications ─────────────────────────────────────────────────────────
    Route::post('/notifications/mark-all-read',  [HomeController::class, 'markAllAsRead'])->name('notifications.markAllRead');
    Route::delete('/notifications/clear-all',    [HomeController::class, 'clearAllNotifications'])->name('notifications.clearAll');
    Route::get('/notifications/{id}/read',       [HomeController::class, 'markAsRead'])->name('notifications.read');
    Route::delete('/notifications/{id}',         [HomeController::class, 'removeNotification'])->name('notifications.remove');
    Route::get('/notifications/list',            [NotificationController::class, 'index'])->name('business.notifications.index');

    // ── Tasks — Manager/Admin/ReadOnly ────────────────────────────────────────
    Route::get('/tasks',            [TaskController::class, 'index'])->name('business.tasks.index');
    Route::post('/tasks',           [TaskController::class, 'store'])->name('business.tasks.store');
    Route::put('/tasks/{id}',       [TaskController::class, 'update'])->name('business.tasks.update');
    Route::delete('/tasks/{id}',    [TaskController::class, 'destroy'])->name('business.tasks.destroy');

    // ── Tasks — All levels ────────────────────────────────────────────────────
    Route::get('/my-tasks',               [TaskController::class, 'myTasks'])->name('business.tasks.my');
    Route::post('/my-tasks/{id}/status',  [TaskController::class, 'updateStatus'])->name('business.tasks.updateStatus');

    // ── Employees ─────────────────────────────────────────────────────────────
    Route::get('/employees',                  [EmployeeController::class, 'index'])->name('business.employees.index');
    Route::get('/employees-data',             [EmployeeController::class, 'getDataTable'])->name('employees.data');
    Route::get('/employees-master-data',      [EmployeeController::class, 'getMasterData'])->name('employees.master');
    Route::post('/employees-store',           [EmployeeController::class, 'store'])->name('employees.store');
    Route::post('/employees-update/{id}',     [EmployeeController::class, 'update'])->name('employees.update');
    Route::get('/employees-details/{id}',     [EmployeeController::class, 'getDetails'])->name('employees.details');
    Route::delete('/employees-delete/{id}',   [EmployeeController::class, 'destroy'])->name('employees.destroy');
    Route::get('/employees-unlinked',         [EmployeeController::class, 'getUnlinkedEmployees'])->name('employees.unlinked');
    Route::post('/employees-link-user/{id}',  [EmployeeController::class, 'linkUser'])->name('employees.linkUser');

    
Route::get('/ml/reports',      [MLReportController::class, 'index'])->name('ml.reports');
Route::get('/ml/chart/{name}', [MLReportController::class, 'serveChart'])->name('ml.chart');
Route::post('/ml/flask-start', [MLReportController::class, 'startFlask'])->name('ml.flask.start');
Route::post('/ml/flask-stop',  [MLReportController::class, 'stopFlask'])->name('ml.flask.stop');
Route::get('/ml/flask-status', [MLReportController::class, 'flaskStatus'])->name('ml.flask.status');

    // ── Performance ───────────────────────────────────────────────────────────
    Route::get('/performance/workload',   [PerformanceController::class, 'workload'])->name('business.performance.workload');
    Route::get('/performance/reports',    [PerformanceController::class, 'reports'])->name('business.performance.reports');
    Route::get('/performance/analytics',  [PerformanceController::class, 'analytics'])->name('business.performance.analytics');

    // ── AI Intelligence ───────────────────────────────────────────────────────
    Route::get('/ai/predictions',       [AiController::class, 'predictions'])->name('business.ai.predictions');
    Route::get('/ai/model',             [AiController::class, 'model'])->name('business.ai.model');
    Route::post('/ai/run-prediction',   [AiController::class, 'runPrediction'])->name('business.ai.runPrediction');
    Route::post('/ai/run-prediction',      [AiController::class, 'runPrediction'])->name('business.ai.runPrediction');
    Route::post('/ai/run-all-predictions', [AiController::class, 'runAllPredictions'])->name('business.ai.runAll');

    // ── System Users (Admin & Settings → User Roles) ──────────────────────────
    Route::get('/system-users',                         [SystemUserController::class, 'index'])->name('admin.userroles.index');
    Route::get('/get-users-data',                       [SystemUserController::class, 'getDataTable'])->name('get-users-data');
    Route::get('/system-users-master-data',             [SystemUserController::class, 'getMasterData'])->name('system-users-master-data');
    Route::post('/system-users-store',                  [SystemUserController::class, 'store'])->name('system-users-store');
    Route::post('/system-users-store-permissions',      [SystemUserController::class, 'storePermissions'])->name('system-users-store-permissions');
    Route::post('/system-users-update/{id}',            [SystemUserController::class, 'update'])->name('system-users-update');
    Route::delete('/system-users-delete/{id}',          [SystemUserController::class, 'destroy'])->name('system-users-delete');
    Route::get('/get-user-details/{id}',                [SystemUserController::class, 'getUserDetails'])->name('get-user-details');
    Route::get('/get-user-module-details/{id}',         [SystemUserController::class, 'getUserModuleDetails'])->name('get-user-module-details');

    // ── Admin System Config ───────────────────────────────────────────────────
    Route::get('/admin/system-config', function () {
        return view('admin.systemconfig.index');
    })->name('admin.systemconfig.index');

    // ── Misc ──────────────────────────────────────────────────────────────────
    Route::get('/download-excel', function () {
        $filePath = storage_path('app/public/material_forms/fg_trading.xlsx');
        if (!file_exists($filePath)) abort(404, 'File not found.');
        return response()->download($filePath);
    })->name('download.excel');

    Route::get('/check-auth', function () {
        return response()->json(['logged_in' => Auth::check()]);
    });
});