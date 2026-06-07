<?php
return [
    "common"=>[
        "excel-file-type-err"=>"The file must be in Excel format (XLSX, XLS, CSV)",
        "actions"=>"Actions",
        "perPage"=>"Per Page"
    ],

    'our_qualities' => [
        'info' => 'Our Qualities List',
        'not_found' => 'No qualities found at the moment', // Improved wording
        'created_at' => 'Added Date',
        'name' => 'Name', // More concise
        'status' => 'Status',
        'errors' => [
            'active_limit' => 'Only 4 qualities can be active to be shown to website visitors', // Improved wording
        ],
    ],
    'messages' => [
        'info' => 'Visitors\' Messages',
        'not_found' => 'No visitors\' messages found at the moment', // Improved wording and possessive
        'name' => 'Name', // More concise
        'email' => 'Email',
        'created_at' => 'Received Date',
    ],
'users' => [
    "info" => [
        'default' => 'Personnel Registry',
        "establishment" => "Personnel Directory - Establishment: :acronym",
        "service" => "Personnel Directory - Service: :acronym"
    ],
    "empty" => [
        'default' => "No personnel records found",
        "establishment" => "No personnel assigned to this establishment",
        "service" => "No personnel assigned to this service"
    ],
    'establishment' => "Assigned Establishment",
    'service' => "Assigned Service",
    "full_name" => "Full Name",
    "full_name_fr" => "Name (French)",
    "full_name_ar" => "Name (Arabic)",
    "employee_number" => "Employee ID",
    "social_number" => "Social Security Number",
    "email" => "Official Email",
    "registration_date" => "Registration Date",
    "phone" => "Contact Number",
    "card_number" => "National ID Number",
    "birth_date" => "Date of Birth",
    "birth_place_fr" => "Place of Birth (French)",
    "birth_place_ar" => "Place of Birth (Arabic)",
    "birth_place_en" => "Place of Birth (English)",
    "excel" => [
        "upload" => [
            "success" => "Personnel records imported successfully"
        ]
    ]
],

'wilayates'=>[
        "info"=>"Wilayates List",
        "not_found"=>"No Wilayates Fond at the moment",
        "code"=>"code",
        "designation"=>"Designation",
        "designation_fr"=>"Designation (French)",
        "designation_ar"=>"Designation (Arabic)",
        "designation_en"=>"Designation (English)",
        "registration_date"=>"Registration Date",
"excel" => [
    "upload" => [
        "success" => "Wilayates list uploaded successfully"
    ]
]
    ],
'wilayates' => [
    "info" => "States Directory",
    "not_found" => "No states currently available",
    "code" => "State Code",
    "designation" => "State Name",
    "designation_fr" => "French Name",
    "designation_ar" => "Arabic Name",
    "designation_en" => "English Name",
    "registration_date" => "Registration Date",
    "excel" => [
        "upload" => [
            "success" => "States data imported successfully"
        ]
    ]
],
'dairates' => [
    "info" => "Districts of State (Code: :code)",
    "not_found" => "No districts currently available",
    "code" => "District Code",
    "designation" => "District Name",
    "designation_fr" => "French Name",
    "designation_ar" => "Arabic Name",
    "designation_en" => "English Name",
    "registration_date" => "Registration Date",
    "excel" => [
        "upload" => [
            "success" => "Districts data imported successfully"
        ]
    ]
],
'communes' => [
    "info" => "Municipalities of District (Code: :code)",
    "not_found" => "No municipalities currently available",
    "code" => "Municipality Code",
    "designation" => "Municipality Name",
    "designation_fr" => "French Name",
    "designation_ar" => "Arabic Name",
    "designation_en" => "English Name",
    "registration_date" => "Registration Date",
    "excel" => [
        "upload" => [
            "success" => "Municipalities data imported successfully"
        ]
    ]
],
'fields'=>[
        "info"=>"Fields List",
        "not_found"=>"No Fields Fond at the moment",
        "acronym"=>"Acronym",
        "designation"=>"Designation",
        "designation_fr"=>"Designation (French)",
        "designation_ar"=>"Designation (Arabic)",
        "designation_en"=>"Designation (English)",
        "registration_date"=>"Registration Date",
"excel" => [
    "upload" => [
        "success" => "Fields list uploaded successfully"
    ]
]
    ],
'field_grades' => [
    "info" => "Grade Levels for Field: :acronym",
    "not_found" => "No grade levels currently available",
    "acronym" => "Grade Code",
    "designation" => "Grade Title",
    "designation_fr" => "French Title",
    "designation_ar" => "Arabic Title",
    "designation_en" => "English Title",
    "registration_date" => "Registration Date",
    "excel" => [
        "upload" => [
            "success" => "Grade levels imported successfully"
        ]
    ]
],
'field_specialties' => [
    "info" => "Professional Specialties: :acronym",
    "not_found" => "No specialties currently available",
    "acronym" => "Specialty Code",
    "designation" => "Specialization Title",
    "designation_fr" => "French Title",
    "designation_ar" => "Arabic Title",
    "designation_en" => "English Title",
    "registration_date" => "Registration Date",
    "excel" => [
        "upload" => [
            "success" => "Specializations imported successfully"
        ]
    ]
],

    'occupations'=>[
        "info"=>"Occupations List",
        "info_custom"=>":name 's Occupations List",
        "not_found"=>"No Occupations Fond at the moment",
        "is_active"=>"State",
        "entitled"=>"Entitled",
        "field"=>"Field",
        "experience"=>"Experience",
        "specialty"=>"Specialty",
         "grade"=>"Grade",
         "created_at"=>"Added At",
    ],
    'banking_information'=>[
        "info"=>"Banking information List",
        "info_custom"=>":name 's Banking information",
        "not_found"=>"No Banking information Fond at the moment",
        "bank_acronym"=>"Bank",
         "agency"=>"Agency",
          "agency_code"=>"Agency code",
          "account_number"=>"Account Number",
        "is_active"=>"State",
         "created_at"=>"Added At",
    ],

'banks' => [
    "info" => "Bank Directory",
    "not_found" => "No banks currently available",
    'code' => "Bank Code",
    'acronym' => "Bank Acronym",
    "designation" => "Bank Name",
    "designation_fr" => "French Name",
    "designation_ar" => "Arabic Name",
    "designation_en" => "English Name",
    "created_at" => "Registration Date",
],
    'menus'=>[
        "info"=>"Menus List",
        "not_found"=>"No Menus Fond at the moment",
          "title"=>"Title",
          "state"=>"State",
          "type"=>"Type",
         "created_at"=>"Added At",
    ],
    'external_links'=>[
        "info"=>"External Links List",
        "not_found"=>"No External Links Fond at the moment",
          "name"=>"Name",
          "url"=>"Url",
         "created_at"=>"Added At",
    ],
    'articles'=>[
        "info"=>"Articles List",
        "not_found"=>"No Articles Fond at the moment",
         "created_at"=>"Added At",
         'author'=>"Author",
         'title'=>"Title",
         "articleable_type"=>"Published For",
         "articleable_id"=>"Published In",
          "location"=>"Location",
          "state"=>"State",

    ],
    'sliders'=>[
        "info"=>"Sliders List",
        "not_found"=>"No Sliders Fond at the moment",
         "created_at"=>"Added At",
         'creator'=>"Creator",
         'name'=>"Name",
         "sliderable_type"=>"Published For",
         "sliderable_id"=>"Published In",
          "location"=>"Location",
          "state"=>"State",
    ],

    "slides"=>[
        "info"=>"Slider List",
        "not_found"=>"No Slider Fond at the moment",
         "created_at"=>"Added At",
         'title'=>"Title",
         'order'=>'Order',
         'image'=>"Image",
          "location"=>"Location",
          "state"=>"State",
    ],
    "trends"=>[
        "info"=>"Trends List",
        "not_found"=>"No Trends Fond at the moment",
         "created_at"=>"Added At",
         'title'=>"Title",
          "state"=>"State",
    ],

'establishments' => [
    "info" => "Establishment Directory",
    "not_found" => "No establishments currently registered",
    "created_at" => "Registration Date",
    "acronym" => "Establishment Code",
    "name" => "Official Name",
    "name_fr" => "French Name",
    "name_ar" => "Arabic Name",
    "name_en" => "English Name",
    "email" => "Official Email",
    "address" => "Complete Address",
    "description" => "Description",
    "tel" => "Primary Phone",
    "fax" => "Fax",
    'daira' => "Administrative District",
    'longitude' => "Longitude",
    'latitude' => "Latitude",
    'capacity' => "Maximum Capacity",
    "excel" => [
        "upload" => [
            "success" => "Establishments imported successfully"
        ]
    ]
],


'services' => [
    "info" => "Services List for Establishment",
    "not_found" => "No services currently registered",
    "created_at" => "Registration Date",
    "name" => "Service Name",
    "name_fr" => "Service Name (French)",
    "name_en" => "Service Name (English)",
    "name_ar" => "Service Name (Arabic)",
    "tel" => "Primary Phone",
    "fax" => "Fax",
    "head_service" => "Head of Service",
    "establishment" => "Parent Establishment",
    "type" => "Service Type",
    "specialty" => "Medical Specialty",
    "excel" => [
        "upload" => [
            "success" => "Services imported successfully"
        ]
    ]
],
'coordinators' => [
    "name" => "Name",
    "employee_number" => "Employee ID",
    "email" => "Official Email",
    "registration_date" => "Registration Date",
    "phone" => "Phone Number",
],
"appointments_location_admins" => [
    "name" => "Name",
    "employee_number" => "Employee ID",
    "email" => "Official Email",
    "registration_date" => "Registration Date",
    "phone" => "Phone Number",
],
"available_appointments" => [
    "info" => [
        "follow-ups" => "Follow-up Appointments for Patient: :code",
        "initials" => "Available Appointments - Please Select Preferred Date",
    ],
    "not_found" => "No appointments currently available. Please verify form entries or check again later",
    "date_at" => "Appointment Date",
    "daira" => "District",
    "doctor" => "Assigned Physician",
    "appointments_location" => "Appointment Venue",
],
"confirmed_appointments" => [
    "info" => "Confirmed Appointments",
    "not_found" => "No appointments currently available. Please verify filter entries or check again later",
    "queue_number" => "Queue Number",
    "patient" => "Patient Name",
    "patient_code" => "Patient Code",
    "patient_birth_date" => "Birth Date",
    "patient_tel" => "Phone",
    "year" => "Year",
    "month" => "Month",
    "specialty" => "Specialty",
    "doctor" => "Doctor",
    "doctor_name" => "Doctor",
    'daira' => "District",
    "location" => "Appointment Location",
    "schedule_day" => "Appointment Date",
    "date" => "Appointment Date",
    "type" => "Type",
    "referral_letter" => "Referral Letter"
],
"patient_visits" => [
    "info" => "Patient Visits Reports List",
    "not_found" => "No Patient Visits Reports available. Please verify filter entries or check again later",
    "patient" => "Patient Name",
    "patient_code" => "Patient Code",
    'doctor'=>"Doctor",
    "created_at" => "Creation Date",

],
'medical_files' => [
    "info" => "My relatives medical files",
    "not_found" => "No medical files available yet",
    "code" => "Code",
    'name'=>"Name",
    'year'=>"Year",
    "last_name_fr" => "Last Name (Fr)",
    "last_name_ar" => "Last Name (Ar)",
    "first_name_fr" => "First Name (Fr)",
    "first_name_ar" => "First Name (Ar)",
    "insurance_number" => "Insurance Number",
    'gender' => "Gender",
    "birth_date" => "Date of Birth",
    "tel" => "Phone Number",
    'created_at' => "Record Creation Date"
],

'ratings' => [
    "info" => "Patient Ratings for Dr. :doctor",
    "not_found" => "No patient ratings available yet",
    'doctor' => "Physician",
    'user_id' => "Patient",
    'rating' => "Patient Satisfaction Score (1-5)",
    'created_at' => "Rating Date"
],
'schedules' => [
    "info" => "Services Schedules Lists",
    "not_found" => "No Schedule found",
    "year" => "Year",
    "month" => "Month",
    "name" => "Designation",
    "name_fr" => "Designation (Fr)",
    "name_en" => "Designation (En)",
    "name_ar" => "Designation (Ar)",
    "state" => "Publication Status",
     "created_at"=>"Creation Date",
    "service" => "Medical Service Rated",
    "created_by" => "Created By"
],
'schedule_days' => [
    "info" => 'The planning ":name" dates lists',
    "not_found" => "No dates found at the moment",
    'doctor' => "Doctor",
    "specialty" => "Specialty",
    'day_at' => "Appointment Date",
    'available_number' => "Available Appointments",
    'confirmed_number' => "Confirmed Appointments",
    'state' => "Schedule Availability",
    'appointment_location' => "Appointments Location"
],
'services' => [
    "info" => ":establishment's Medical Services Directory",
    "not_found" => "No medical services currently available",
    "type" => "Service Category",
    "head_of_service_id" => "Department Chief",
    "establishment" => "Parent establishment",
    "created_at" => "Service Establishment Date",
    "specialty" => "Medical Specialty"
],

'visits' => [
    "info" => "Patient Visit Records",
    "not_found" => "No visit records found",
    'appointment' => "Appointment Reference",
    "code" => "Patient ID",
    'patient' => "Patient Name",
    'doctor' => "Attending Physician",
    "date" => "Consultation Date"
],
'images' => [
    "info" => "images files list",
    "not_found" => "No Images Files found",
    'display_name' => "Display Name",
    "use_case" => "Use Case",
    'created_at' => "Added At",
    'preview' => "Preview",
],
'files' => [
    "info" => "Pdfs files list",
    "not_found" => "No Pdfs Files found",
    'display_name' => "Display Name",
    "use_case" => "Use Case",
    'created_at' => "Added At",
    'preview' => "Preview",
    "download"=>"Download File"
],
];
