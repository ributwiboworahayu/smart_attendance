<?php


use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdminController;
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

Route::get('/', function () {
    return redirect('dashboard');
})->middleware('auth')->name('index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // Super Admin Routes
    Route::prefix('superadmin')->group(function () {
        Route::get('/', [SuperAdminController::class, 'index'])->name('superadmin');
        Route::get('users-admins', [SuperAdminController::class, 'adminUsers'])->name('admin.users');
        Route::get('units', [SuperAdminController::class, 'units'])->name('units');
        Route::get('roles', [SuperAdminController::class, 'roles'])->name('roles');

        Route::prefix('datatables')->group(function () {
            Route::get('admin-users', [SuperAdminController::class, 'adminUsersDatatables'])->name('admin.users.datatables');
            Route::get('units', [SuperAdminController::class, 'unitsDatatables'])->name('units.datatables');
            Route::get('roles', [SuperAdminController::class, 'rolesDatatables'])->name('roles.datatables');
        });
    });

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User Routes
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/users/status', [UserController::class, 'status'])->name('users.status');

    // Employee Routes
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
    Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
    Route::get('/employees/{id}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::put('/employees/{id}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::delete('/employees/{id}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
    Route::get('/employees/status', [EmployeeController::class, 'status'])->name('employees.status');

    // Payroll Routes
    Route::get('/payroll', [PayrollController::class, 'index'])->name('payroll.index');
    Route::get('/payroll/additions', [PayrollController::class, 'additions'])->name('payroll.additions');
    Route::post('/payroll/additions', [PayrollController::class, 'storeAdditions'])->name('payroll.storeAdditions');
    Route::get('/payroll/approval', [PayrollController::class, 'approval'])->name('payroll.approval');
    Route::post('/payroll/approval', [PayrollController::class, 'approve'])->name('payroll.approve');
    Route::get('/payroll/history', [PayrollController::class, 'history'])->name('payroll.history');

    // Benefits Routes
    Route::get('/benefits', [BenefitsController::class, 'index'])->name('benefits.list');
    Route::get('/benefits/{id}', [BenefitsController::class, 'show'])->name('benefits.show');
    Route::get('/benefits/employee', [BenefitsController::class, 'employee'])->name('benefits.employee');

    // Tax Routes
    Route::get('/taxes/rules', [TaxController::class, 'rules'])->name('taxes.rules');
    Route::get('/taxes/report', [TaxController::class, 'report'])->name('taxes.report');
    Route::get('/taxes/compliance', [TaxController::class, 'compliance'])->name('taxes.compliance');

    // Report Routes
    Route::get('/reports/salary', [ReportController::class, 'salary'])->name('reports.salary');
    Route::get('/reports/benefits', [ReportController::class, 'benefits'])->name('reports.benefits');
    Route::get('/reports/taxes', [ReportController::class, 'taxes'])->name('reports.taxes');

    // Setting Routes
    Route::get('/settings/general', [SettingController::class, 'general'])->name('settings.general');
    Route::get('/settings/salary', [SettingController::class, 'salary'])->name('settings.salary');
    Route::get('/settings/benefits', [SettingController::class, 'benefits'])->name('settings.benefits');

    // Audit Routes
    Route::get('/audit/payroll', [AuditController::class, 'payroll'])->name('audit.payroll');
    Route::get('/audit/log', [AuditController::class, 'log'])->name('audit.log');

    // Help Routes
    Route::get('/help', [HelpController::class, 'index'])->name('help');

    // Notification Routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
});

require __DIR__ . '/auth.php';
