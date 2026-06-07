<?php

use App\Enum\Web\RoutesNames;
use App\Http\Controllers\Web\AppointmentsLocationAdminController;
use App\Http\Controllers\Web\DoctorController;
use Illuminate\Support\Facades\Route;



Route::group(['middleware' => ['auth', 'maintenance','web.account.active', 'can:doctor-access']], function () {

    Route::get('/doctorSpace', [DoctorController::class, 'showDoctorPage'])
        ->name(RoutesNames::DOCTOR_ROUTE->value);
    Route::get('/medicalFiles', [DoctorController::class, 'showMedicalFilesPage'])
        ->name(RoutesNames::MEDICAL_FILES_ROUTE->value);
    Route::get('/patientVisits', [DoctorController::class, 'showPatientVisitsPage'])
        ->name(RoutesNames::PATIENT_VISITS_ROUTE->value);
});
