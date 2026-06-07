<?php

use App\Enum\Web\RoutesNames;
use App\Http\Controllers\Web\AppointmentsLocationAdminController;
use Illuminate\Support\Facades\Route;



Route::group(['middleware' => ['auth', 'maintenance','web.account.active', 'can:appointments-location-admin-access']], function () {

    Route::get('/appointmentLocationSpace', [AppointmentsLocationAdminController::class, 'showAppointmentsLocationAdminPage'])
        ->name(RoutesNames::APPOINTMENTS_LOCATION_ADMIN_ROUTE->value);

});
