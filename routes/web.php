<?php

use App\Http\Controllers\admin\DapilController;
use App\Http\Controllers\admin\DesaController;
use App\Http\Controllers\admin\ElectionController;
use App\Http\Controllers\admin\ElectionTypeController;
use App\Http\Controllers\admin\GenderController;
use App\Http\Controllers\admin\KabupatenController;
use App\Http\Controllers\admin\KecamatanController;
use App\Http\Controllers\admin\PartyController;
use App\Http\Controllers\admin\PeriodeController;
use App\Http\Controllers\admin\ProfileController;
use App\Http\Controllers\admin\ProjectController;
use App\Http\Controllers\admin\ProvinsiController;
use App\Http\Controllers\admin\RelasiDapilController;
use App\Http\Controllers\admin\RoleController;
use App\Http\Controllers\admin\TPSController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', function () {
    return redirect()->route('dashboard.index');
})->name('home');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('/dashboard', DashboardController::class);
    Route::resource('/project', ProjectController::class);
    Route::resource('/dapil', DapilController::class);
    Route::resource('/relasi-dapil', RelasiDapilController::class);
    Route::resource('/election', ElectionController::class);
    Route::resource('/tps', TPSController::class);
    Route::controller(TPSController::class)->group(function () {
        Route::post('/tps/import', 'import')->name('tps.import');
        Route::post('/tps/export-excel', 'export_excel')->name('tps.export.excel');
    });

    Route::group(['prefix' => 'master-data',], function () {
        Route::resource('/user', UserController::class);
        Route::resource('/gender', GenderController::class);
        Route::resource('/role', RoleController::class);

        Route::resource('/provinsi', ProvinsiController::class);
        Route::resource('/kabupaten', KabupatenController::class);
        Route::resource('/kecamatan', KecamatanController::class);
        Route::resource('/desa', DesaController::class);
        Route::controller(DesaController::class)->group(function () {
            Route::post('/desa/export-excel', 'export_excel')->name('desa.export.excel');
        });

        Route::resource('/party', PartyController::class);
        Route::resource('/periode', PeriodeController::class);
        Route::resource('/election-type', ElectionTypeController::class);
        Route::resource('/profile', ProfileController::class);
    });
});
