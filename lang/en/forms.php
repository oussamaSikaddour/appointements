<?php

return [
'common' => [
    'actions' => [
        'submit' => 'Submit',
        'reset' => 'Reset Form',
    ],
    'errors' => [
        "default"=>"An error occurred. Please contact your IT team.", // More professional and informative
        "not_match"=>[
            'phone' => 'Phone number must start with 05, 06, or 07 and contain exactly 10 digits.',
            "land_line"=>"The Landline Number must start with 0 and contain exactly 9 digits"
        ],
        'img' => [
            'not_img' => 'The file must be an image.',
            "not_imgs"=>"The files must be images",
        ],
        'user' => [
            'not_exists' => 'The :attribute field is required.',
        ],
    ],
],

'site_parameters' => [
    'steps' => [
        'first' => [
            'password' => 'Password',
            'email' => 'Your Email',
        ],
        'last' => [
            'state' => "State",
            'enable' => "Enable",
            'disable' => "Disable",
        ],
    ],
"actions"=>[
    "download_db"=>"Download Database"
],
    'responses' => [
        'you_can_pass' => 'You have the credentials to Update the App State', // Corrected grammar
        'success' => 'You have successfully updated the App State',
    ],
    'errors' => [
        'no_access' => "You don't have the necessary credentials for the next Step", // Corrected spelling
        'user_not_found' => 'Check your email and password and try again', // Corrected spelling
    ],
],
    'login' => [
        'email' => 'Your Email',
        'password' => 'Your Password',
        'actions' => [
            'submit' => 'Sign In',
        ],
        'responses' => [
            'success' => 'You have been successfully logged in.',
        ],
        'errors' => [
            'too_many_attempts' => 'Too many login attempts. Please try again later.',
            'invalid_credentials' => 'The provided credentials are invalid.',
        ],
    ],

    'register' => [
        'instructions' => [
            'email' => 'The email must be valid. A verification code will be sent to it.',
            'code' => 'Enter the code sent to your email.',
        ],
        'email' => 'Your Email',
        'steps' => [
            'first' => [
                'password' => 'Password',
            ],
            'last' => [
                'code' => 'Verification Code',
            ],
        ],
        'actions' => [
            'get_code' => 'Send Code',
            'get_new_code' => 'Send New Code',
            'submit' => 'Sign Up',
        ],
        'responses' => [
            'new_code' => 'A new verification code has been sent to your email.',
            'success' => 'You have been successfully registered.',
        ],
        'errors' => [
            'verification_code' => 'The verification code is incorrect or has expired.',
        ],

    ],
    'forgot_password' => [
        'instructions' => [
            'email' => 'The email must be valid. A verification code will be sent to it.',
            'code' => 'Enter the code sent to your email.',
        ],
        'email' => 'Your Email',
        'steps' => [
            'last' => [
                'code' => 'Verification Code',
                'password' => 'New Password',
            ],
        ],
        'actions' => [
            'get_code' => 'Send Code',
        ],
        'responses' => [
            'new_code' => 'A new verification code has been sent to your email.',
            'success' => 'You have successfully recovered your account.',
        ],
        'errors' => [
            'no_user' => 'No user found with this email. Please check and try again.', // Improved error message
            'verification_code' => 'The verification code is incorrect or has expired.',
        ],
    ],
    'change_password' => [
        'infos' => [
            'redirect' => 'After changing your password, you will be logged out.',
        ],
        'old_pwd' => 'Your Old Password',
        'pwd' => 'Your New Password',
        'responses' => [
            'success' => 'The change was successful. You will be logged out now.', // Corrected spelling
        ],
        'errors' => [
            'old_pwd' => 'Please check your old password and try again.', // Improved error message
           'invalid_current' => "Password modification is restricted to Super Administrators and the account owner",
        ],
    ],
'change_mail' => [
    'infos' => [
        'redirect' => 'You will be logged out after changing your email.', // More concise and natural
    ],
    'pwd' => 'Password',
    'mail' => 'Current Email', // More consistent capitalization
    'new_mail' => 'New Email',
    'responses' => [
        'success' => 'Your email has been successfully changed. You will now be logged out.', // More user-friendly
    ],
    'errors' => [
        'auth' => 'Please verify your current email and password and try again.', // More precise and professional
    ],
],
'general_infos' => [

    'email' => "Email",
    'logo'=>"Logo",
    'phone'=>"Phone",
    'landline'=>"Landline",
    'fax'=>"Fax",
    'map'=>"Google Map",
    'responses' => [
        'success' => 'You have successfully updated the general information of your App', // Corrected spelling
    ],

],
'manage_hero' => [

     'title_ar'=>"Title in Arab",
     'title_fr'=>"Title in french",
     'title_en'=>"Title in english",
     'sub_title_ar'=>"SubTitle in arabic",
     'sub_title_fr'=>"SubTitle in french",
     'sub_title_en'=>"SubTitle in english",
     "images"=>"Hero Page Images",

    'responses' => [
        'success' => 'You have successfully updated the Hero Page information of your App', // Corrected spelling
    ],

],
'manage_hero' => [

     'title_ar'=>"Title in Arab",
     'title_fr'=>"Title in french",
     'title_en'=>"Title in english",
     'sub_title_ar'=>"SubTitle in arabic",
     'sub_title_fr'=>"SubTitle in french",
     'sub_title_en'=>"SubTitle in english",
     "images"=>"Hero Page Images",

    'responses' => [
        'success' => 'You have successfully updated the Hero Page information of your App', // Corrected spelling
    ],

],
'manage_about_us' => [

     'title_ar'=>"Title in Arab",
     'title_fr'=>"Title in french",
     'title_en'=>"Title in english",
     'description_ar'=>"Description  in arabic",
     'description_fr'=>"Description  in french",
     'description_en'=>"Description  in english",
     "image"=>"Hero Page Image",

    'responses' => [
        'success' => 'You have successfully updated the AboutUs Page information of your App', // Corrected spelling
    ],

],
'our_quality' => [

     'name_ar'=>"Title in Arab",
     'name_fr'=>"Title in french",
     'name_en'=>"Title in english",
     "image"=>"Image",
    'responses' => [
        'add_success' => 'You have successfully added a New Quality', // Corrected spelling
        'update_success' => 'You have successfully updated the selected Quality', // Corrected spelling
    ],

],
'socials' => [
    'youtube' => 'YouTube', // Capitalized for consistency
    'facebook' => 'Facebook', // Capitalized
    'github' => 'GitHub', // Capitalized
    'linkedin' => 'LinkedIn', // Corrected spelling and capitalized
    'instagram' => 'Instagram', // Capitalized
    'tiktok' => 'TikTok', // Capitalized
    'responses' => [
        'success' => 'You have successfully updated your socials', // Corrected spelling and lowercase "socials"
    ],
],
"user" => [
    'instructions' => [
        "email" => "A valid email is required. A verification code will be sent to this address.",
    ],
    'email' => "Email Address",
    "last_name_fr" => "Last Name (French)",
    "last_name_ar" => "Last Name (Arabic)",
    "first_name_fr" => "First Name (French)",
    "first_name_ar" => "First Name (Arabic)",
    "profile_img" => "Profile Picture",
    'is_paid' => 'Paid Status',
    'is_active' => 'Active Status',
    "cv" => "Curriculum Vitae",
    "card_number" => "National ID Number",
    "birth_date" => "Date of Birth",
    'birth_place_fr' => "Place of Birth (French)",
    'birth_place_ar' => "Place of Birth (Arabic)",
    "address_fr" => "Address (French)",
    "address_ar" => "Address (Arabic)",
    "address_en" => "Address (English)",
    'phone' => "Phone Number",
    "employee_number" => "Employee ID",
    "social_number" => "Social Security Number",
    'responses' => [
       "add" => [
        "user" => "User account created successfully",
        "personnel" => "Personnel record added successfully",
       ],
       "update" => [
        "user" => "User account updated successfully: :name",
        "personnel" => "Personnel record updated successfully: :name",
       ],
    ],
],

'role' => [
    'errors' => [
        'user_id_required' => 'User selection is required',
        'user_id_exists'   => 'The specified user account does not exist',
        'roles_required'   => 'At least one role must be selected',
        'roles_array'      => 'Roles must be provided as valid identifiers',
        'roles_exist'      => 'One or more specified roles are invalid',
        'user_not_found'   => 'The requested user account was not found',
        'error_title'      => 'Role Assignment Error',
    ],
    'responses' => [
        'success'      => 'User roles have been successfully updated',
        'own_success'  => 'Your roles have been updated. For security purposes, you have been logged out of all sessions.',
    ],
],

"wilaya" => [
    'designation_fr' => "French Name",
    'designation_ar' => "Arabic Name",
    'designation_en' => "English Name",
    'code' => "State Code",
    'responses' => [
        'add_success' => 'State created successfully',
        'update_success' => 'State updated successfully',
    ],
],
"daira" => [
    'designation_fr' => "French Name",
    'designation_ar' => "Arabic Name",
    'designation_en' => "English Name",
    'code' => "District Code",  // Changed from "Diara Code"
    'responses' => [
        'add_success' => 'District created successfully',
        'update_success' => 'District updated successfully',
    ],
],
"commune" => [
    'designation_fr' => "French Name",
    'designation_ar' => "Arabic Name",
    'designation_en' => "English Name",
    'code' => "Municipality Code",  // More formal than "Commune Code"
    'responses' => [
        'add_success' => 'Municipality created successfully',
        'update_success' => 'Municipality updated successfully',
    ],
],
"field" => [
    'designation_fr' => "French Designation",
    'designation_ar' => "Arabic Designation",
    'designation_en' => "English Designation",
    'acronym' => "Acronym",
    'responses' => [
        'add_success' => 'Professional field created successfully',
        'update_success' => 'Field updated successfully',
    ],
],
"field_grade" => [
    'designation_fr' => "French Designation",
    'designation_ar' => "Arabic Designation",
    'designation_en' => "English Designation",
    'acronym' => "Grade Code",
    'field_id' => "Professional Field",  // Fixed typo: 'filed_id' → 'field_id'
    'responses' => [
        'add_success' => 'Grade level created successfully',
        'update_success' => 'Grade level updated successfully',
    ],
],
"field_specialty" => [
    'designation_fr' => "French Designation",
    'designation_ar' => "Arabic Designation",
    'designation_en' => "English Designation",
    'acronym' => "Specialty Code",
    'field_id' => "Professional Field",
    'responses' => [
        'add_success' => 'Professional specialty created successfully',
        'update_success' => 'Specialty updated successfully',
    ],
],
"occupation" => [
    'field_id' => "Professional Field",
    'field_specialty_id' => "Area of Specialization",
    'field_grade_id' => "Professional Grade",
    "description_fr" => "Professional Description (French)",
    "description_en" => "Professional Description (English)",
    "description_ar" => "Professional Description (Arabic)",
    "experience" => "Years of Professional Experience",
    'errors' => [
        'field_required' => 'Professional field selection is required',
        'field_exists' => 'The selected professional field is invalid',
        'field_specialty_exists' => 'The selected specialization area is invalid',
        'field_grade_exists' => 'The selected professional grade is invalid',
    ],
    'responses' => [
        'add_success' => 'Professional occupation has been successfully added',
        'update_success' => 'Professional occupation has been successfully updated',
    ],
],
"banking_information" => [
    "agency_fr" => "Bank Branch (French)",
    "agency_ar" => "Bank Branch (Arabic)",
    "agency_en" => "Bank Branch (English)",
    "agency_code" => "Branch Code",
    "account_number" => "Account Number",
    "bank_id" => "Financial Institution",
    'errors' => [
        'bankable_id_required' => 'Associated entity identifier is required',
        'bankable_type_required' => 'Associated entity type is required',
        'bankable_type_invalid' => 'The specified entity type is invalid',
    ],
    'responses' => [
        'add_success' => 'Banking information has been successfully added',
        'update_success' => 'Banking information has been successfully updated',
    ],
],
"bank"=>[
    "acronym"=>"Acronym",
    "designation_ar"=>"Designation in arabic",
    "designation_fr"=>"Designation in french",
    "designation_en"=>"Designation in english",
     "code"=>"Code",
    'responses' => [
        'add_success' => 'You have successfully added a New Bank', // Corrected spelling
        'update_success' => 'You have successfully updated the selected Bank', // Corrected spelling
    ],
],
"article"=>[
     'title_fr'=>"Title In French",
     'title_ar'=>"Title In Arabic",
     'title_en'=>"Title In English",
      "content_fr"=>"Content In French",
      "content_en"=>"Content In English",
      "content_ar"=>"Content In Arabic",
      "published_at"=>"Published At",
      "articleable_type"=>"Published Type",
      "articleable_id"=>"Published In",
      "images"=>"Images",
    'responses' => [
        'add_success' => 'You have successfully added a New Article', // Corrected spelling
        'update_success' => 'You have successfully updated the selected Article', // Corrected spelling
    ],
],
"external_link"=>[
     "name_fr"=>"Name in French",
     "name_ar"=>"Name in Arabic",
     "name_en"=>"Name in English",
      'url'=>"Url",
      "menu_id"=>"Menu Name",
    'responses' => [
        'add_success' => 'You have successfully added a New External Link', // Corrected spelling
        'update_success' => 'You have successfully updated the selected External Link', // Corrected spelling
    ],
],
"menu"=>[
       'title_fr'=>"Title In French",
       'title_ar'=>"Title In Arabic",
        'title_en'=>"Title In English",
        "type"=>"Type",
        "state"=>"State",
    'responses' => [
        'add_success' => 'You have successfully added a New Menu', // Corrected spelling
        'update_success' => 'You have successfully updated the selected Menu', // Corrected spelling
    ],
],



"slide"=>[
     'title_fr'=>"Title In French",
     'title_ar'=>"Title In Arabic",
     'title_en'=>"Title In English",
      "content_fr"=>"Content In French",
      "content_en"=>"Content In English",
      "content_ar"=>"Content In Arabic",
      "order"=>"Slide Order",
      "slider_id"=>"Slider",
      'image'=>"Image",
      'responses' => [
        'add_success' => 'You have successfully added a New Slide', // Corrected spelling
        'update_success' => 'You have successfully updated the selected Slide', // Corrected spelling
    ],
],
"slider"=>[
      "name"=>"Name",
      "sliderable_type"=>"Published Type",
      "sliderable_id"=>"Published In",
      "user_id"=>"Publisher",
       'state'=>"Publishing State",
      'responses' => [
        'add_success' => 'You have successfully added a New Slide', // Corrected spelling
        'update_success' => 'You have successfully updated the selected Slide', // Corrected spelling
    ],
],
"trend"=>[
     'title_fr'=>"Title In French",
     'title_ar'=>"Title In Arabic",
     'title_en'=>"Title In English",
      "content_fr"=>"Content In French",
      "content_en"=>"Content In English",
      "content_ar"=>"Content In Arabic",
      "start_at"=>"From",
      "end_at"=>"Until",
      'responses' => [
        'add_success' => 'You have successfully added a New Trend', // Corrected spelling
        'update_success' => 'You have successfully updated the selected Trend', // Corrected spelling
    ],
],
"menu"=>[
     'name_fr'=>"Name In French",
     'name_ar'=>"Name In Arabic",
     'name_en'=>"Name In English",
     'url'=>"Url",
      'responses' => [
        'add_success' => 'You have successfully added a New Trend', // Corrected spelling
        'update_success' => 'You have successfully updated the selected Trend', // Corrected spelling
    ],
],

'appointment' => [
    "patient_id" => "Patient",
    "schedule_day_id" => "Scheduled Day",
    'appointments_location_id' => "Appointment Location",
    "type" => "Appointment Type",
    "day_at" => "Appointment Date",
    "status" => "Appointment Status",
    "specialty_id" => "Medical Specialty",
    "daira_id" => "Administrative District",
    "doctor_id" => "Assigned Physician",
    "referral_letter" => "Referral Letter (Image Format)",
    'responses' => [
        'add_success' => "New appointment has been scheduled successfully",
        'update_success' => "Appointment details have been updated successfully",
    ],
    "errors" => [
        "not_found" => [
            "patient" => "Medical file selection is required",
            "schedule_day" => "Appointment date selection is required",
            "doctor" => "Physician assignment is required"
        ],
        'referral_required' => 'A referral letter is mandatory for initial consultations',
        "maxed_out" => "This date is no longer available. All appointments for this day were booked during your request process",
        "min_gap_days" => "A minimum waiting period of :days days is required between appointments in this specialty. Selected date: :date. Previous appointment: :last"
    ]
],
'establishment' => [
    "acronym" => "Establishment Acronym",
    "name_fr" => "Establishment Name (French)",
    "name_ar" => "Establishment Name (Arabic)",
    "name_en" => "Establishment Name (English)",
    "email" => "Email Address",
    "address_fr" => "Complete Address (French)",
    "address_ar" => "Complete Address (Arabic)",
    "address_en" => "Complete Address (English)",
    "description_fr" => "Establishment Description (French)",
    "description_ar" => "Establishment Description (Arabic)",
    "description_en" => "Establishment Description (English)",
    "tel" => "Primary Phone Number",
    "fax" => "Fax Number",
    'capacity' => "Maximum Capacity",
    'daira_id' => "Administrative District",
    'longitude' => "Longitude",
    'latitude' => "Latitude",
    'responses' => [
        'add_success' => "New establishment has been registered successfully",
        'update_success' => "Establishment information has been updated successfully",
    ],
],
'service' => [
    "name_fr" => "Service Name (French)",
    "name_ar" => "Service Name (Arabic)",
    "name_en" => "Service Name (English)",
    "specialty" => "Medical Specialty",
    "type" => "Service Type",
    "tel" => "Primary Phone",
    "fax" => "Fax",
    "head_of_service_id" => "Head of Service",
    "establishment_id" => "Affiliated Establishment",

    'responses' => [
        'add_success' => "Healthcare service created successfully",
        'update_success' => "Service updated successfully",
    ],
],
"coordinator"=>[
    "user_id"=>"Employee Name",
    'responses' => [
        'add_success' => "Coordinator added successfully",
    ],
],
"appointments-location-admin"=>[
    "user_id"=>"Employee Name",
    "appointments_location_id"=>"Appointments Location",
    'responses' => [
        'add_success' => "Appointments location admin added successfully",
    ],
],
'medical_file' => [
    "last_name_fr" => "Last Name (Fr)",
    "first_name_fr" => "First Name (Fr)",
    "last_name_ar" => "Last Name (Ar)",
    "first_name_ar" => "First Name (Ar)",
    'gender' => "Gender",
    "code" => "Patient Code",
    "birth_place_fr" => "Place of Birth (Fr)",
    "birth_place_ar" => "Place of Birth (Ar)",
    "birth_place_en" => "Place of Birth (En)",
    "birth_date" => "Date of Birth",
    "address_fr" => "Complete Address (Fr)",
    "address_ar" => "Complete Address (Ar)",
    "address_en" => "Complete Address (En)",
    "tel" => "Phone Number",
    "opened_by" => "Created By",
    "insurance_number" => "Insurance Policy Number",
    'responses' => [
        'add_success' => "New medical file has been created successfully",
        'update_success' => "Medical file has been updated successfully",
    ],
],
'rating' => [
    'doctor_id' => "Doctor",
    'user_id' => "Patient",
    'rating' => "Rating (1-5)",
    'comment_fr' => "Feedback Comment (French)",
    'comment_ar' => "Feedback Comment (Arabic)",
    'comment_en' => "Feedback Comment (English)",

    'responses' => [
        'add_success' => "New rating has been submitted successfully",
        'update_success' => "Your rating has been updated successfully",
    ],
],
'schedule' => [
    "year" => "Calendar Year",
    "month" => "Month",
    "name_fr" => "Schedule Name (French)",
    "name_en" => "Schedule Name (English)",
    "name_ar" => "Schedule Name (Arabic)",
    "description_fr" => "Schedule Description (French)",
    "description_ar" => "Schedule Description (Arabic)",
    "description_en" => "Schedule Description (English)",
    "state" => "Status",
    "service_id" => "Medical Service",
    "opened_by" => "Created By",
    'responses' => [
        'add_success' => "New schedule has been created successfully",
        'update_success' => "Schedule has been updated successfully",
    ],
    'errors' => [
        'not_found' => [
            'creator'=>"Service coordinator needed to create a schedule",
            'service'=>"Service needed to create a schedule",
        ]
    ],
],
'schedule_day' => [
    'doctor_id' => "Assigned Doctor",
    'schedule_id' => "Parent Schedule",
    'day_at' => "Appointment Day",
    'available_number' => "Available Appointments",
    'appointments_location_id' => "Consultation Location",
    'responses' => [
        'add_success' => "Doctor's daily schedule has been created successfully",
        'update_success' => "Doctor's schedule has been updated successfully",
    ],
],

'patient_visit' => [
    'patient_id' => "Patient",
    'doctor_id' => "Doctor",

    'report_fr' => "Medical Report (Fr)",
    'report_ar' => "Medical Report (Ar)",
    'report_en' => "Medical Report (En)",
    'responses' => [
        "add_success"=>"Patient Visit Report added successful",
        'update_success' => "Patient Visit Report has been updated successfully",
    ],
],

'image' => [
    'display_name' => "Display Name",
    'use_case' => "Use Case",
    'real_image' => "Image File",
    'responses' => [
        "add_success" => "Image File added successfully",
        'update_success' => "Image File has been updated successfully",
    ],
],

];
