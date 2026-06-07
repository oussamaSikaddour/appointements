<?php

use App\Enum\Web\RoutesNames;
use App\Http\Controllers\Web\AuthorController;
use Illuminate\Support\Facades\Route;

// ============================================================
// Author Routes (Admin-only for now)
// Prefix: /
// Middleware:
//   - auth           → user must be logged in
//   - maintenance    → app must not be in maintenance mode
//   - can:admin-access → restricted to users with admin access
// ============================================================

Route::group(['middleware' => ['auth', 'maintenance','web.account.active', 'can:admin-access']], function () {

    // Show all articles
    // URL: /articles
    // Route Name: author.articles
    Route::get('/articles', [AuthorController::class, 'showArticlesPage'])
        ->name(RoutesNames::ARTICLES_ROUTE->value);

    // Show trend analytics
    // URL: /trends
    // Route Name: author.trends
    Route::get('/trends', [AuthorController::class, 'showTrendsPage'])
        ->name(RoutesNames::TRENDS_ROUTE->value);
});
