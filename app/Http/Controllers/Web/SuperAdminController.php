<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    /**
     * Display the Site Parameters Page.
     *
     * @return View
     */
    public function showSiteParametersPage(): View
    {
        $title = __("pages.site_parameters.name"); // Localized title for site parameters
        return view('pages.site-parameters', compact('title'));
    }

    /**
     * Show the Super Admin Dashboard.
     *
     * @return View
     */
    public function showSuperAdminPage(): View
    {
        $title = __("pages.super_admin_space.name"); // Localized dashboard title

        // Modal configuration to add a user
        $modalTitle = "modals.user.actions.add.user";
        $modalContent = [
            "name" => 'default.user-modal',
            "parameters" => [],
        ];

        return view('pages.super-admin.dashboard', compact('title', 'modalTitle', 'modalContent'));
    }
    /**
     * Show the Super Admin Dashboard.
     *
     * @return View
     */
    public function showOccupationsFieldsPage(): View
    {
        $title = __("pages.occupation_fields.name"); // Localized dashboard title

        // Modal configuration to add a user
        $modalTitle = "modals.field.actions.new";
        $modalContent = [
            "name" => 'default.super-admin.field-modal',
            "parameters" => [],
        ];

        return view('pages.super-admin.occupations-fields', compact('title', 'modalTitle', 'modalContent'));
    }
    /**
     * Show the Super Admin Dashboard.
     *
     * @return View
     */
    public function showWilayatesPage(): View
    {
        $title = __("pages.wilayates.name"); // Localized dashboard title

        // Modal configuration to add a user
        $modalTitle = "modals.wilaya.actions.new";
        $modalContent = [
            "name" => 'default.super-admin.wilaya-modal',
            "parameters" => [],
        ];

        return view('pages.super-admin.wilayates', compact('title', 'modalTitle', 'modalContent'));
    }
    /**
     * Show the Super Admin Dashboard.
     *
     * @return View
     */
    public function showWilayaPage(Request $request)
    {
        $parameters = $request->query(); // Get all query parameters

        // Check for required slider parameters
        if (array_key_exists('id', $parameters) && array_key_exists('code', $parameters)) {
            // Generate localized title using slider name
            $title = __("pages.wilaya.name", [
                "code" => $parameters['code'],
            ]);
            // Modal configuration for adding a slide to the slider
            $modalTitle = "modals.daira.actions.add";
            $modalContent = [
                "name" => 'default.super-admin.daira-modal',
                "parameters" => [
                     'wilayaId'=>$parameters['id']
                ],
            ];

            // Return the slides view with editor and modal config
            return view('pages.super-admin.wilaya', compact('title', 'modalTitle', 'modalContent', 'parameters'));
        }
    }

    /**
     * Show the Landing Page Management Page.
     *
     * @return View
     */
    public function showManageLandingPage(): View
    {
        $title = __("pages.manage_landing.name"); // Localized landing page title
        return view('pages.super-admin.landing-page', compact('title'));
    }

    /**
     * Show the Banks Management Page.
     *
     * @return View
     */
    public function showBanksPage(): View
    {
        $title = __("pages.banks.name"); // Localized banks page title

        // Modal configuration for adding a bank
        $modalTitle = "modals.bank.actions.add";
        $modalContent = [
            "name" => 'default.super-admin.bank-modal',
            "parameters" => [],
        ];

        return view('pages.super-admin.banks', compact('title', 'modalTitle', 'modalContent'));
    }

    /**
     * Show the Messages Page.
     *
     * @return View
     */
    public function showMessagesPage(): View
    {
        $title = __("pages.messages.name"); // Localized messages page title
        return view('pages.super-admin.messages', compact('title'));
    }

    /**
     * Show the Landing Scene General Info Page.
     *
     * @return View
     */
    public function showGeneralInfosPage(): View
    {
        $title = __("pages.general_infos.name"); // Localized general info title
        return view('pages.super-admin.general-infos', compact('title'));
    }

    /**
     * Show the Hero Scene Management Page.
     *
     * @return View
     */
    public function showManageHeroScene(): View
    {
        $title = __("pages.manage_hero.name"); // Localized hero section title
        return view('pages.super-admin.scenes.hero', compact('title'));
    }

    /**
     * Show the About Us Scene Management Page.
     *
     * @return View
     */
    public function showManageAboutUsScene(): View
    {
        $title = __("pages.manage_about_us.name"); // Localized about-us section title
        return view('pages.super-admin.scenes.about-us', compact('title'));
    }

    /**
     * Show the "Our Qualities" Section Management Page.
     *
     * @return View
     */
    public function showManageOurQualitiesPage(): View
    {
        $title = __("pages.manage_our_qualities.name"); // Localized qualities section title

        // Modal configuration for adding a new quality
        $modalTitle = "modals.our_quality.actions.new";
        $modalContent = [
            "name" => 'default.super-admin.our-quality-modal',
            "parameters" => [],
        ];

        return view('pages.super-admin.our-qualities', compact('title', 'modalTitle', 'modalContent'));
    }

    /**
     * Show the Social Media Links Management Page.
     *
     * @return View
     */
    public function showManageSocials(): View
    {
        $title = __("pages.manage_socials.name"); // Localized social links management title
        return view('pages.super-admin.socials', compact('title'));
    }
}
