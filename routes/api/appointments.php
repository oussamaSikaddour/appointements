<?php

use App\Http\Controllers\Api\AppointmentController;
use Illuminate\Support\Facades\Route;

// ==========================================================
// Locale-aware, protected API routes for appointments
// Base URL: /api/{locale}
// Middleware:
//   - auth:sanctum → ensures the user is authenticated
//   - apiMaintenance → blocks access if the app is in maintenance mode
//   - api.account.active → ensures the user account is active
// ==========================================================

Route::prefix('api/{locale}')
    ->middleware(['auth:sanctum', 'apiMaintenance', 'api.account.active'])
    ->group(function () {

        // 📅 Fetch schedule days
        Route::get('scheduleDays', [AppointmentController::class, 'getScheduleDays']);
        Route::get('printConfirmation/{appointment}', [AppointmentController::class, 'printAppointMentPdf']);

        // 🩺 Appointments CRUD (excluding update)
        Route::apiResource('appointments', AppointmentController::class)->except('update');
});
