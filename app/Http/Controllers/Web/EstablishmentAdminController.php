<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class EstablishmentAdminController extends Controller
{
    /**
     * Display the Services Page.
     *
     * @return View
     */
    public function showEstablishmentAdminPage(): View
    {
        $user = Auth::user(); // Retrieve the authenticated user (not used here)


        $title = __("pages.establishment_admin_space.name"); // Localized title

        // Modal configuration for adding a service
        $modalTitle = "modals.user.actions.add.personnel";
        $modalTitleOptions=['name'=> $user->establishment->acronym];

        $establishmentId=$user->establishment_id;
        $modalContent = [
            "name" => 'default.user-modal',
            "parameters"=>[
                        "establishmentId" => $establishmentId,
            ]
        ];

        // Return the services admin view
        return view('pages.establishment-admin.space', compact('title', 'modalTitle','modalTitleOptions', 'modalContent','establishmentId'));
    }
    public function showServicesPage(): View
    {
        $user = Auth::user(); // Retrieve the authenticated user (not used here)
        $title = __("pages.services.name"); // Localized title

        $establishmentId=$user->establishment_id;
        // Modal configuration for adding a service
        $modalTitle = "modals.service.actions.add";
        $modalContent = [
            "name" => 'default.establishment-admin.service-modal',
            "parameters" => ['establishmentId'=>$establishmentId],
        ];

        // Return the services admin view
        return view('pages.establishment-admin.services', compact('title', 'modalTitle', 'modalContent','establishmentId'));
    }

}
