<?php

use App\Enum\Web\RoutesNames;
use App\Http\Controllers\Web\SuperAdminController;
use Illuminate\Support\Facades\Route;

// ==================================================================
// ⚙️ Unprotected Site Parameter Route (should likely be protected?)
// ==================================================================
Route::get('/siteParameters', [SuperAdminController::class, 'showSiteParametersPage'])
    ->name(RoutesNames::SITE_PARAMETERS->value);

// ===========================================================================================
// 🛡️ Super Admin Routes (Accessible only to authenticated super-admin users)
// Middleware:
//   - auth                  → user must be authenticated
//   - maintenance           → disabled if app is in maintenance mode
//   - can:super-admin-access → user must have 'super-admin-access' permission
// ===========================================================================================
Route::group(['middleware' => ['auth', 'maintenance','web.account.active', 'can:super-admin-access']], function () {

    // 📊 Super Admin Dashboard
    Route::get('/dashboard', [SuperAdminController::class, 'showSuperAdminPage'])
        ->name(RoutesNames::SUPER_ADMIN_ROUTE->value);
    Route::get('/wilayates', [SuperAdminController::class, 'showWilayatesPage'])
        ->name(RoutesNames::WILAYATES->value);
    Route::get('/dairates', [SuperAdminController::class, 'showWilayaPage'])
        ->name(RoutesNames::WILAYA->value);
    Route::get('/fields', [SuperAdminController::class, 'showOccupationsFieldsPage'])
        ->name(RoutesNames::OCCUPATION_FIELDS->value);

    // 🧩 Manage Landing Page
    Route::get('/manage-landing-page', [SuperAdminController::class, 'showManageLandingPage'])
        ->name(RoutesNames::LANDING_PAGE->value);

    // 🏦 Bank Management
    Route::get('/manage-banks', [SuperAdminController::class, 'showBanksPage'])
        ->name(RoutesNames::BANKS->value);

    // ✉️ Message Center
    Route::get('/messages', [SuperAdminController::class, 'showMessagesPage'])
        ->name(RoutesNames::MESSAGES->value);

    // 📋 General Infos Page
    Route::get('/generalInfos', [SuperAdminController::class, 'showGeneralInfosPage'])
        ->name(RoutesNames::GENERAL_INFOS->value);

    // 🌟 Qualities Management
    Route::get('/ourQualities', [SuperAdminController::class, 'showManageOurQualitiesPage'])
        ->name(RoutesNames::MANAGE_OUR_QUALITIES->value);

    // 🎨 Landing Page Scene Routes (Grouped under a prefix)
    Route::prefix('landing-page-scenes')->group(function () {

        // Hero Section
        Route::get('/hero', [SuperAdminController::class, 'showManageHeroScene'])
            ->name(RoutesNames::MANAGE_HERO->value);

        // About Us Section
        Route::get('/about-us', [SuperAdminController::class, 'showManageAboutUsScene'])
            ->name(RoutesNames::MANAGE_ABOUT_US->value);

        // Socials Section
        Route::get('/socials', [SuperAdminController::class, 'showManageSocials'])
            ->name(RoutesNames::MANAGE_SOCIALS->value);
    });
});
