<?php

use App\Http\Controllers\Api\MedicalFileController;
use App\Models\MedicalFile;
use Illuminate\Support\Facades\Route;

// ==========================================================
// Locale-aware, protected API routes for medicalFiles
// Nested under: /api/{locale}/medicalFiles
// Middleware:
//   - auth:sanctum → ensures the user is authenticated
//   - apiMaintenance → blocks access if the app is in maintenance mode
//
// These routes are scoped to a specific user ID.
// ==========================================================

Route::group([
    'prefix' => 'api/{locale}',
    'middleware' => ['auth:sanctum', 'apiMaintenance','api.account.active'],
], function () {

     Route::apiResource('medicalFiles', MedicalFileController::class);
});
