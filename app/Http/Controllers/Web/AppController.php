<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class AppController extends Controller
{
    /**
     * Display the Index Page.
     *
     * @return View The landing/index page view
     */
    public function showIndexPage(): View
    {
        // Set the page title using localization
        $title = __("pages.index.name");

        // Return the 'pages.index' view with the title
        return view('pages.Index', compact('title'));
    }

    /**
     * Set the Application Language.
     *
     * @param string $lang The requested language code
     * @return RedirectResponse Redirect back to the previous page
     */
    public function setLang(string $lang): RedirectResponse
    {
        // Define supported locale options
        $supportedLocales = ['en', 'fr', 'ar'];

        // Abort with a 400 Bad Request if the provided locale is not supported
        if (!in_array($lang, $supportedLocales)) {
            abort(400, 'Unsupported language.');
        }

        // Set the application locale for the current request
        app()->setLocale($lang);

        // Store the selected locale in the session for persistence
        session()->put('locale', $lang);

        // Redirect back to the previous page
        return redirect()->back();
    }

    /**
     * Display the Maintenance Mode Page.
     *
     * @return View The maintenance mode view
     */
    public function showIsOnMaintenanceModePage(): View
    {
        // Set the page title using localization
        $title = __("pages.maintenance-mode.page-title");

        // Return the 'pages.maintenance-mode' view with the title
        return view('pages.maintenance-mode', compact('title'));
    }
    public function showToggleAccountStatusPage(): View
    {
        // Set the page title using localization
        $title = __("pages.toggle-account-status.page-title");

        // Return the 'pages.maintenance-mode' view with the title
        return view('pages.toggle-account-status', compact('title'));
    }
}
