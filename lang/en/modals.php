<?php
 return [
"our_quality"=>[
            "actions"=>[
                "new"=>"Add New Quality",
                "update"=>"Update The Selected Quality"
            ]
            ],
          "message"=>[
            "actions"=>[
                "reply"=>"Send A reply"
            ]
            ],
'user' => [
    'actions' => [
'add' => [
    "user" => "Create User Account",
    "personnel" => "Add Personnel - Establishment: :name"
],
'update' => [
    "user" => "Update User: :name",
    "personnel" => "Update Personnel: :name"
],
        'manage' => [
            'roles' => 'Manage :name\'s Roles',
            'occupations' => 'Manage :name\'s Occupations',
            'banking_information' => 'Manage :name\'s Banking Details',
        ],
    ],
],
'field' => [
    'actions' => [
        'add' => 'Create New Professional Field',
        'update' => 'Update Field: :acronym',
        'manage' => [
            'grades' => 'Manage Grade Levels',
            'specialties' => 'Manage Specializations',
        ],
    ],
],
'wilaya' => [
    'actions' => [
        'add' => 'Add New State',
        'update' => 'Update State: :code',
        'manage' => [
            'view' => 'View State Details',
        ],
    ],
],
'daira' => [
    'actions' => [
        'add' => 'Add New District',
        'update' => 'Update District: :code',
    ],
],
'bank' => [
    'actions' => [
        'add' => 'Add New Bank',
        'update' => 'Update The Selected Bank',
    ],
],
'service' => [
    'actions' => [
        'add' => 'Add New Service',
        'update' => 'Update The Selected Service',
        "manage_coordinators" => "Manage :name Coordinators",
    ],
],
'menu' => [
    'actions' => [
        'add' => 'Add New Menu',
        'update' => 'Update The Selected Menu',
    ],
],
'external_link' => [
    'actions' => [
        'add' => 'Add New External Link',
        'update' => 'Update The Selected External Link',
    ],
],
'slider' => [
    'actions' => [
        'add' => 'Add New Slider',
        'update' => 'Update The Selected Slider',
    ],
],
'slide' => [
    'actions' => [
        'add' => 'Add New Slide',
        'update' => 'Update The Selected Slide',
    ],
],
'article' => [
    'actions' => [
        'add' => 'Add New Article',
        'update' => 'Update The Selected Article',
    ],
],
'trend' => [
    'actions' => [
        'add' => 'Add New Trend',
        'update' => 'Update The Selected Trend',
    ],
],
'establishment' => [
    'actions' => [
        'add' => 'Create New Establishment',
        'update' => 'Update Establishment: :acronym',
    ],
],
'schedule' => [
    'actions' => [
        'add' => 'Create New Schedule',
        'update' => 'Update the Schedule :name',
        "manage" => 'Manage The Planning ":name" Dates',
    ],
],
'medical_file' => [
    "actions" => [
        "add" => "Create A Medical File",
        "update" => 'Update the Medical File Code : " :code" '
    ]
],
"appointment" => [
    "instruction" => "Select medical specialty to display available dates",
    "actions" => [
        "add" => [
            "simple" => "Make a specialist medical appointment",
            "initial" => "Make a specialist medical appointment for the Patient : :code",
            "follow-up" => "Make A Follow-up For the Patient : :code",
        ],
        "update" => "Update the Appointment of the Patient : :code"
    ],
    "errors"=>[
        'too_close_to_cancel' => 'You cannot cancel this appointment because it is less than 3 days away.',
    ]
],
"patient_visit" => [
    "actions" => [
        "add" => [
            "simple" => "Add Consultation Report",
            "detailed" => "Add Patient :code Consultation Report"
        ],
        'update' => "Update Patient :code Consultation Report",
        "manage" => [
            "images" => "Manage Patient :name Visit Documents (Image Format)",
            "files" => "Manage Patient :name Visit Documents (PDF Format)",
        ]
    ]
],
 ];
