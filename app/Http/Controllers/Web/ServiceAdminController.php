<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceAdminController extends Controller
{
    public function showServiceAdminPage(): View
    {
        $user = Auth::user(); // Retrieve the authenticated user (not used here)


        $title = __("pages.service_admin_space.name"); // Localized title

        // Modal configuration for adding a service
        $modalTitle = "modals.schedule.actions.add";
        $modalTitleOptions=['name'=> $user->service->acronym];

        $serviceId=$user->service_id;
        $modalContent = [
            "name" => 'default.service-admin.schedule-modal',
            "parameters"=>[
                        "serviceId" => $serviceId,
            ]
        ];

        // Return the services admin view
        return view('pages.service-admin.space', compact('title', 'modalTitle','modalTitleOptions', 'modalContent','serviceId'));
    }
    public function showManageAppointmentsLocationAdminsPage(): View
    {
        $user = Auth::user(); // Retrieve the authenticated user (not used here)


        $title = __("pages.manage_appointments_location_admins.name"); // Localized title



        $establishmentId=$user->establishment_id;


        // Return the services admin view
        return view('pages.service-admin.manage-appointments-location-admins', compact('title', 'establishmentId'));
    }
}
