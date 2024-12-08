<?php

use App\Http\Controllers\AccreditationProjectController;
use App\Http\Controllers\AllocationController;
use App\Http\Controllers\BrokerController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\ExecutiveController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {return view('welcome');})->name('home');

Route::group([
    // 'prefix' => 'dashboard',
    // 'as' => 'dashboard.',
    'middleware' => ['check.cookie'],
    // 'namespace' => 'App\Http\Controllers',
],function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('profile/{user}', [UserController::class, 'profile'])->name('users.profile');

    Route::post('allocations/import', [AllocationController::class, 'import'])->name('allocations.import');
    Route::post('executives/import', [ExecutiveController::class, 'import'])->name('executives.import');

    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::post('reports/export', [ReportController::class, 'export'])->name('reports.export');


    Route::resources([
        'users' => UserController::class,
        'currencies' => CurrencyController::class,
        'brokers' => BrokerController::class,
        'organizations' => OrganizationController::class,
        'items' => ItemController::class,
        'projects' => ProjectController::class,
        'allocations' => AllocationController::class,
        'executives' => ExecutiveController::class,
        'accreditations' => AccreditationProjectController::class
    ]);

});
