<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Display the Admin (Establishment) Page.
     *
     * @return View
     */
    public function showAdminPage(): View
    {
        $user = Auth::user(); // Retrieve the authenticated user (not used here)
        $title = __("pages.admin_space.name"); // Localized title

        $modalTitle = "modals.establishment.actions.add";
        $modalContent = [
            "name" => 'default.admin.establishment-modal',
            "parameters" => [],
        ];

        $containsTinyMce = true;
        // Return the sliders admin view
        return view('pages.admin.admin-space', compact('title', 'modalTitle', 'modalContent','containsTinyMce'));

    }


    /**
     * Display the Menus Page.
     *
     * @return View
     */
    public function showMenusPage(): View
    {
        $user = Auth::user(); // Retrieve the authenticated user (not used here)
        $title = __("pages.menus.name"); // Localized title

        // Modal configuration for adding a menu
        $modalTitle = "modals.menu.actions.add";
        $modalContent = [
            "name" => 'default.admin.menu-modal',
            "parameters" => [],
        ];

        // Return the menus admin view
        return view('pages.admin.menus', compact('title', 'modalTitle', 'modalContent'));
    }

    /**
     * Display a specific Menu Page with query parameters.
     *
     * @param Request $request
     * @return View|null
     */
    public function showMenuPage(Request $request)
    {
        $parameters = $request->query(); // Get all query parameters from the URL

        // Check if required parameters exist
        if (array_key_exists('id', $parameters) && array_key_exists('title', $parameters)) {
            // Generate localized title using dynamic title
            $title = __("pages.menu.name", [
                "title" => $parameters['title'],
            ]);

            // Modal configuration for adding external links to a menu
            $modalTitle = "modals.external_link.actions.add";
            $modalContent = [
                "name" => 'default.admin.external-link-modal',
                "parameters" => [
                    "menuId" => $parameters['id'],
                ],
            ];

            // Return the specific menu view with dynamic data
            return view('pages.admin.menu', compact('title', 'modalTitle', 'modalContent', 'parameters'));
        }
    }

    /**
     * Display the Sliders Page.
     *
     * @return View
     */
    public function showSlidersPage(): View
    {
        $title = __("pages.sliders.name"); // Localized title

        // Modal configuration for adding a slider
        $modalTitle = "modals.slider.actions.add";
        $modalContent = [
            "name" => 'default.admin.slider-modal',
            "parameters" => [],
        ];

        // Return the sliders admin view
        return view('pages.admin.sliders', compact('title', 'modalTitle', 'modalContent'));
    }

    /**
     * Display a specific Slider Page with slides and editor.
     *
     * @param Request $request
     * @return View|null
     */
    public function showSliderPage(Request $request)
    {
        $parameters = $request->query(); // Get all query parameters

        // Check for required slider parameters
        if (array_key_exists('id', $parameters) && array_key_exists('name', $parameters)) {
            // Generate localized title using slider name
            $title = __("pages.slider.name", [
                "name" => $parameters['name'],
            ]);

            // Add user ID to parameters (useful for ownership or tracking)
            $parameters['user_id'] = Auth::id();

            // Modal configuration for adding a slide to the slider
            $modalTitle = "modals.slide.actions.add";
            $modalContent = [
                "name" => 'default.admin.slide-modal',
                "parameters" => [
                    "sliderId" => $parameters['id'],
                ],
            ];

            // Flag to include TinyMCE editor in the view
            $containsTinyMce = true;

            // Return the slides view with editor and modal config
            return view('pages.admin.slides', compact('title', 'modalTitle', 'modalContent', 'containsTinyMce', 'parameters'));
        }
    }


    /**
     * Display a specific Slider Page with slides and editor.
     *
     * @param Request $request
     * @return View|null
     */
    public function showEstablishmentPage(Request $request)
    {
        $parameters = $request->query(); // Get all query parameters

        // Check for required slider parameters
        if (array_key_exists('id', $parameters) && array_key_exists('acronym', $parameters)) {
            // Generate localized title using slider name
            $title = __("pages.establishment.name", [
                "acronym" => $parameters['acronym'],
            ]);

            // Add user ID to parameters (useful for ownership or tracking)
            $parameters['user_id'] = Auth::id();


            $modalTitleOptions=['name'=> $parameters['acronym']];
            // Modal configuration for adding a slide to the slider
            $modalTitle = "modals.user.actions.add.personnel";
            $modalContent = [
                "name" => 'default.user-modal',
                "parameters" => [
                    "establishmentId" => $parameters['id'],
                ],
            ];

            // Return the slides view with editor and modal config
            return view('pages.admin.establishment', compact('title', 'modalTitle','modalTitleOptions', 'modalContent', 'parameters'));
        }
    }



}
