<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

// ==========================================================
// 🌐 General API Routes (non-versioned or fallback layer)
// ==========================================================
// Prefix: /api/{locale}/...
// Locale is dynamic to support i18n/l10n

Route::group([
    "prefix" => "{locale}", // 📌 Dynamically capture language (e.g., en, fr)
], function () {

    // 🔓 Logout (requires authentication)
    Route::get('logout', [AuthController::class, 'logout'])
        ->middleware(['auth:sanctum']);

    Route::get('logoutAll', [AuthController::class, 'logoutAllDevices'])
        ->middleware(['auth:sanctum']);
    // 🏗️ Site Setup First Step
    // → Possibly unauthenticated, used before system bootstrap
    Route::post('site-params-first-step', [AuthController::class, 'siteParamsFirstStep']);

    // 🔒 Site Setup Last Step
    // → Requires auth + super-admin permission
    Route::post('site-params-last-step', [AuthController::class, 'siteParamsLastStep'])
        ->middleware(['auth:sanctum',  'api.account.active', 'can:super-admin-access']);
});
