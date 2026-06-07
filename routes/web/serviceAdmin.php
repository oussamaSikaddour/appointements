<?php

use App\Enum\Web\RoutesNames;
use App\Http\Controllers\Web\ServiceAdminController;
use Illuminate\Support\Facades\Route;



Route::group(['middleware' => ['auth', 'maintenance','web.account.active', 'can:service-admin-access']], function () {

    Route::get('/serviceAdminSpace', [ServiceAdminController::class, 'showServiceAdminPage'])
        ->name(RoutesNames::SERVICE_ADMIN_ROUTE->value);
    Route::get('/manageALAdmins', [ServiceAdminController::class, 'showManageAppointmentsLocationAdminsPage'])
        ->name(RoutesNames::MANAGE_APPOINTMENTS_LOCATION_ADMINS_ROUTE->value);

});
