<?php
return [
    "index"=>[
           "name"=>"Landing Page",
    ],

'site_parameters' => [
    'name' => 'Site Parameters',
    'titles' => [
        'main' => 'Site Parameters',
    ],
],
    "login"=>[
               "name"=>"Login",

               'links' => [
                'register' => 'New to ' . config('app.name') . ' ? Register Now',
                'forgot_password' => 'Forgot Your Password?',
                   ],

            "titles"=>[
                    'main' => 'Sign In', // Moved title to a separate key
                ]
            ],

    'register' => [
                'name' => 'Register',
                'links' => [
                    'login' => 'Have an account already?',
                ],
                'titles' => [
                   'main'=> 'Sign Up',
                ]
            ],

    "logout"=>"Log Out",
    'forgot_password' => [
                'name' => 'Forgot Password',
                'titles' =>[
                     "main"=>'Recover your Account',
                     ]
            ],

    "profile"=>[

            'name'=>"Profile",
            "titles"=>[
                "main"=>"Welcome To Your Profile"
            ]
            ],
    "profile"=>[

            'name'=>"Profile",
            "titles"=>[
                "main"=>"Welcome To Your Profile"
            ]
            ],
    "change_password"=>[
            'name'=>"Change Password",
            "titles"=>[
                "main"=>"Change Your Password"
            ]
            ],
"change_email"=>[
        "name"=>"Change Mail",
        "titles"=>[
            "main"=>"Change Your Mail"
        ]
        ],

"user_space"=>[
           'name'=>"User Space",
           "titles"=>[
              "main"=>"Welcome to Your Space"
           ]

           ],
"medical_file" => [
    'name' => "Medical File",
    "titles" => [
        "main" => 'Manage The Medical File of :name code : :code'
    ]
],
"medical_files" => [
    'name' => "Medical Files",
    "titles" => [
        "main" => "Patient Medical Records - Consultation History"
    ]
],
"patient_visits" => [
    'name' => "Patient Visits",
    "titles" => [
        "main" => ":name :code - Medical Visits History"
    ]
],
"admin_space"=>[
           'name'=>"Admin Space",
           "titles"=>[
              "main"=>"Welcome To The Admin Dashboard"
           ]

           ],
"super_admin_space"=>[
           'name'=>"Super Admin Space",
           "titles"=>[
              "main"=>"Welcome To The Super Admin Dashboard"
           ]

           ],
"wilaya" => [
    'name' => "States",
    "titles" => [
        "main" => "State Management"
    ]
],
"dairates" => [
    'name' => "Districts",
    "titles" => [
        "main" => "District Management (State Code: :code)"
    ]
],
"occupation_fields" => [
    'name' => "Professional Fields",
    "titles" => [
        "main" => "Manage Professional Fields"
    ]
],
"establishment_admin_space" => [
    'name' => "Establishment Administration",
    "titles" => [
        "main" => "Establishment Admin Dashboard"
    ]
],
"appointments_location_admin_space" => [
    'name' => "Appointments Location Administration",
    "titles" => [
        "main" => "Appointments Location Admin Dashboard"
    ]
],
"service_admin_space" => [
    'name' => "Service Administration",
    "titles" => [
        "main" => "Service Admin Dashboard"
    ]
],
"service_admin_space" => [
    'name' => "Service Administration",
    "titles" => [
        "main" => "Service Admin Dashboard"
    ]
],
"manage_appointments_location_admins" => [
    'name' => "Manage Appointments Locations",
    "titles" => [
        "main" => "Appointments Locations Dashboard"
    ]
],
"doctor_space" => [
    'name' => "Doctor Space",
    "titles" => [
        "main" => "Welcome Doctor"
    ]
],

'manage_landing'=>[
    "name"=>"Manage Landing Page",
    "titles"=>[
        "main"=>"Manage Landing Page Information"
    ],
],
"general_infos"=>[
    "name"=>"Manage General Information",
    "titles"=>[
        "main"=>"Manage App General Information"
    ],
],
"manage_hero"=>[
    "name"=>"Manage Hero Page",
    "titles"=>[
        "main"=>"Manage Hero Page"
    ],
],
"manage_about_us"=>[
    "name"=>"Manage AboutUs Page",
    "titles"=>[
        "main"=>"Manage AboutUs Page"
    ],
],
"manage_our_qualities"=>[
    "name"=>"Manage Our Qualities Page",
    "titles"=>[
        "main"=>"Manage Our Qualities Page"
    ],
],
'manage_socials' => [
    'name' => 'Manage Socials Page',
    'titles' => [
        'main' => 'Manage Your Socials', // Removed extra space
    ],
],
'messages' => [
    'name' => 'Manage Messages',
    'titles' => [
        'main' => 'Manage Visitors\' Messages', // Added apostrophe for possessive
    ],
],
'banks' => [
    'name' => 'Manage banks',
    'titles' => [
        'main' => 'Manage banks', // Added apostrophe for possessive
    ],
],
'services' => [
    'name' => 'Manage Services',
    'titles' => [
        'main' => 'Manage Services', // Added apostrophe for possessive
    ],
],
'articles' => [
    'name' => 'Manage Articles',
    'titles' => [
        'main' => 'Manage Articles', // Added apostrophe for possessive
    ],
],

'menus' => [
    'name' => 'Manage Menus',
    'titles' => [
        'main' => 'Manage Menus', // Added apostrophe for possessive
    ],
],

'menu' => [
    'name' => 'Manage the menu ',
    'titles' => [
        'main' => 'Manage External Links of the menu :title', // Added apostrophe for possessive
    ],
],
'sliders' => [
    'name' => 'Manage Sliders',
    'titles' => [
        'main' => 'Manage Sliders', // Added apostrophe for possessive
    ],
],
'slider' => [
    'name' => 'Manage Slides',
    'titles' => [
        'main' => 'Manage :name Slides', // Added apostrophe for possessive
    ],
],
'trends' => [
    'name' => 'Manage Trends',
    'titles' => [
        'main' => 'Manage Trends', // Added apostrophe for possessive
    ],
],
'establishment' => [
    'name' => ':acronym Details',
    'titles' => [
        'main' => 'Manage :acronym Details',
    ],
],



];
