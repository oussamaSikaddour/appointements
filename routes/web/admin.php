<?php

use App\Enum\Web\RoutesNames;
use App\Http\Controllers\Web\AdminController;
use Illuminate\Support\Facades\Route;

// ===========================================================
// Admin-only Web Routes
// Prefix: / (root)
// Middleware:
//   - auth           → user must be authenticated
//   - maintenance    → app must not be in maintenance mode
//   - can:admin-access → user must have admin permission
// ===========================================================

Route::group(['middleware' => ['auth', 'maintenance','web.account.active', 'can:admin-access']], function () {

    // Establishment management page
    // URL: /establishment
    // Name: admin.establishment
    Route::get('/establishments', [AdminController::class, 'showAdminPage'])
        ->name(RoutesNames::ADMIN_ROUTE->value);

        // Single slider form/edit
    // URL: /slider
    // Name: admin.slider
    Route::get('/establishment', [AdminController::class, 'showEstablishmentPage'])
        ->name(RoutesNames::ESTABLISHMENT_ROUTE->value);


    // Menus list view
    // URL: /menus
    // Name: admin.menus
    Route::get('/menus', [AdminController::class, 'showMenusPage'])
        ->name(RoutesNames::MENUS_ROUTE->value);

    // Single menu form/edit
    // URL: /menu
    // Name: admin.menu
    Route::get('/menu', [AdminController::class, 'showMenuPage'])
        ->name(RoutesNames::MENU_ROUTE->value);

    // Sliders list view
    // URL: /sliders
    // Name: admin.sliders
    Route::get('/sliders', [AdminController::class, 'showSlidersPage'])
        ->name(RoutesNames::SLIDERS_ROUTE->value);

    // Single slider form/edit
    // URL: /slider
    // Name: admin.slider
    Route::get('/slider', [AdminController::class, 'showSliderPage'])
        ->name(RoutesNames::SLIDER_ROUTE->value);





});
