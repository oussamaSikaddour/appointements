<?php

use App\Enum\Web\RoutesNames;
use App\Http\Controllers\Web\EstablishmentAdminController;
use Illuminate\Support\Facades\Route;

// ===========================================================
// Admin-only Web Routes
// Prefix: / (root)
// Middleware:
//   - auth           → user must be authenticated
//   - maintenance    → app must not be in maintenance mode
//   - can:admin-access → user must have admin permission
// ===========================================================

Route::group(['middleware' => ['auth', 'maintenance','web.account.active', 'can:establishment-admin-access']], function () {

    Route::get('/EstablishmentAdminSpace', [EstablishmentAdminController::class, 'showEstablishmentAdminPage'])
        ->name(RoutesNames::ESTABLISHMENT_ADMIN_ROUTE->value);
    Route::get('/Services', [EstablishmentAdminController::class, 'showServicesPage'])
        ->name(RoutesNames::SERVICES_ROUTE->value);
});
