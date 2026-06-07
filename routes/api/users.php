<?php



use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

// =======================================================
// Locale-aware API routes for User management
// Prefix: /api/{locale}/users
// =======================================================

Route::group([
    'prefix' => 'api/{locale}',
    'middleware' => ['apiMaintenance'], // 🚧 Block access during maintenance
], function () {

    // 🟢 Public endpoint — anyone can view users list
    // GET /api/{locale}/users
    Route::apiResource('users', UserController::class)->only(['index','show']);

    // 🔐 Authenticated endpoints — active users only
    // Includes: store (create), show, update, destroy
    Route::apiResource('users', UserController::class)
        ->except(['index','show','store'])
        ->middleware([
            'auth:sanctum',
            'api.account.active',
            'throttle:60,1', // ⏳ Prevent abuse (60 requests/min)
        ]);

    // 🛠️ Admin-only endpoints — restricted to users with admin permissions
Route::middleware([
    'auth:sanctum',
    'api.account.active',
    'throttle:30,1',
])->group(function () {
    Route::post('bulk-users-add', [UserController::class, 'bulkAddUsers']);
});
});
