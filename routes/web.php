<?php

use App\Enum\Web\RoutesNames;
use App\Http\Controllers\Web\AppController;
use Illuminate\Support\Facades\Route;

Route::get('lang/{lang}', [AppController::class, 'setLang'])
    ->where('lang', 'en|fr|ar') // Validate language parameter
    ->name(RoutesNames::SET_LANG->value);

Route::get('/maintenanceMode', [AppController::class, 'showIsOnMaintenanceModePage'])
    ->name(RoutesNames::IS_ON_MAINTENANCE_MODE->value);
Route::get('/toggle-status', [AppController::class, 'showToggleAccountStatusPage'])
    ->name(RoutesNames::TOGGLE_ACCOUNT_STATUS->value);
Route::group(['middleware' => 'maintenance'], function () {
    Route::get('/', [AppController::class, 'showIndexPage'])
        ->name(RoutesNames::INDEX->value);
});
