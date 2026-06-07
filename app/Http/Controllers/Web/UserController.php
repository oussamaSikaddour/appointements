<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Show the user home (dashboard) page.
     *
     * @return View The view for the user home area
     */
    public function showUserPage(): View
    {



        $title = __("pages.user_space.name"); // Localized title

        // Modal configuration for adding a service
        $modalTitle = "modals.medical_file.actions.add";

        $modalContent = [
            "name" => 'default.user.medical-file-modal',
            "parameters"=>[
            ]
        ];

        return view('pages.user.home', compact('title', 'modalTitle', 'modalContent'));
    }


        public function showMedicalFilePage(Request $request)
    {
   $parameters = $request->query(); // Get all query parameters from the URL

        // Check if required parameters exist
        if (array_key_exists('id', $parameters) && array_key_exists('code', $parameters)) {
            // Generate localized title using dynamic title
            $title = __("pages.medical_file.name", [
                "code" => $parameters['code'],
            ]);

            // Modal configuration for adding external links to a menu
            $modalTitle = "modals.appointment.instruction";

            $modalContent = [
                "name" => 'default.appointment-modal',
                "parameters" => [
                    "patientId" => $parameters['id'],
                    "code" => $parameters['code'],
                ],
            ];

            // Return the specific menu view with dynamic data
            return view('pages.user.medical-file', compact('title', 'modalTitle', 'modalContent', 'parameters'));
        }
    }

    /**
     * Show the user's profile page.
     *
     * @return View The view for editing/viewing the profile
     */
    public function showProfilePage(): View
    {
        // Localized title for the profile page
        $title = __("pages.profile.name");

        // Load the user profile view
        return view('pages.user.profile', compact('title'));
    }

    /**
     * Show the change password page.
     *
     * @return View The view for changing user password
     */
    public function showChangePasswordPage(): View
    {
        // Localized title for the change password page
        $title = __("pages.change_password.name");

        // Load the change password view
        return view('pages.user.change-password', compact('title'));
    }

    /**
     * Show the change email page.
     *
     * @return View The view for changing user email address
     */
    public function showChangeEmailPage(): View
    {
        // Localized title for the change email page
        $title = __("pages.change_email.name");

        // Load the change email view
        return view('pages.user.change-email', compact('title'));
    }
}
