<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
    public function showDoctorPage(): View
    {
        $user = Auth::user(); // Retrieve the authenticated user (not used here)
        $title = __("pages.doctor_space.name"); // Localized title
        $doctorId =$user->id;
        $isForDoctor=true;
        return view('pages.doctor.space', compact('title','doctorId','isForDoctor'));
    }

        public function showMedicalFilesPage(Request $request)
{
   $parameters = $request->query(); // Get all query parameters from the URL

 $doctor = Auth::user();
 $doctorId = $doctor->id;
    $isForDoctor=true;
            // Generate localized title using dynamic title
            $title = __("pages.medical_files.name");

            // Return the specific menu view with dynamic data
            return view('pages.doctor.medical-files', compact('title', 'doctorId','isForDoctor'));

    }

            public function showPatientVisitsPage(Request $request)
    {
   $parameters = $request->query(); // Get all query parameters from the URL

        // Check if required parameters exist
        if (array_key_exists('id', $parameters) && array_key_exists('code', $parameters) && array_key_exists('name', $parameters)) {
            // Generate localized title using dynamic title
            $title = __("pages.patient_visits.name", [
                "code" => $parameters['code'],
            ]);

            // Modal configuration for adding external links to a menu
            $modalTitle = "modals.patient_visit.actions.add.detailed";
            $modalTitleOptions=[
                'code'=>$parameters['code']
            ];
            $modalContent = [
                "name" => 'default.doctor.patient-visit-modal',
                "parameters" => [
                    "patientId" => $parameters['id'],
                ],
            ];

            $containsTinyMce = true;
            // Return the specific menu view with dynamic data
            return view('pages.doctor.patient-visits',
            compact('title',
            'modalTitle',
            'modalTitleOptions',
            'modalContent', 'parameters',
            'containsTinyMce'

        ));
        }
    }

}
