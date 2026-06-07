<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentsLocationAdminController extends Controller
{
    public function showAppointmentsLocationAdminPage(): View
    {

        $user = Auth::user(); // Retrieve the authenticated user (not used here)
        $title = __("pages.appointments_location_admin_space.name"); // Localized title
        $appointmentsLocationId=$user->appointments_location_id;
        return view('pages.appointments-location-admin.space', compact('title','appointmentsLocationId'));
    }
}
