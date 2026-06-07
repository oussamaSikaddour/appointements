<?php

return [
        'index' => [
              'name' => 'Page d\'accueil',
            ],
'site_parameters' => [
    'name' => 'Paramètres du site',
    'titles' => [
        'main' => 'Paramètres du site',
    ],

],
        'login' => [
            'name' => 'Connexion',
            'links' => [
                'register' => 'Nouveau sur ' . config('app.name') . ' ? Inscrivez-vous maintenant',
                'forgot_password' => 'Mot de passe oublié ?',
            ],
            "titles"=>[

                'main' => 'S\'identifier',

                   ]
        ],
        'register' => [
            'name' => 'S\'inscrire',
            'links' => [
                'login' => 'Vous avez déjà un compte ?',
            ],
            'titles' => [

            'main'=>'Inscription',
            ]
        ],

'logout' => 'Déconnexion',
    'forgot_password' => [
            'name' => 'Mot de passe oublié',
            'titles' =>[
                'main'=>'Récupérer votre compte'
            ],
        ],
    'profile' => [
            'name' => 'Profil',
            'titles' => [
                'main' => 'Bienvenue sur votre profil',
            ],
        ],
'change_password' => [
            'name' => 'Modifier le mot de passe',
            'titles' => [
                'main' => 'Modifier votre mot de passe',
            ],
        ],
'change_email' => [
            'name' => "Modifier l'email",
            'titles' => [
                'main' => 'Modifier votre adresse email',
            ],
        ],
"user_space" => [
    'name' => "Espace Utilisateur",
    "titles" => [
        "main" => "Bienvenue dans votre espace"
    ]
],
"medical_file" => [
    'name' => "Dossier Médical",
    "titles" => [
        "main" => 'Gérer Le Dossier Médical de :name code : :code'
    ]
],
"medical_files" => [
    'name' => "Dossiers Médicaux",
    "titles" => [
        "main" => "Dossiers Médicaux - Historique des Consultations"
    ]
],
"patient_visits" => [
    'name' => "Visites des Patients",
    "titles" => [
        "main" => ":name :code - Historique des Visites Médicales"
    ]
],
'admin_space' => [
            'name' => 'Espace Administrateur',
            'titles' => [
                'main' => 'Bienvenue sur le tableau de bord administrateur',
            ],
        ],
'super_admin_space' => [
            'name' => 'Espace Super Administrateur',
            'titles' => [
                'main' => 'Bienvenue sur le tableau de bord Super Administrateur',
            ],
        ],
"wilayates" => [
    'name' => "Wilayas",
    "titles" => [
        "main" => "Gestion des wilayas"
    ]
],
"wilaya" => [
    'name' => "Dairas",
    "titles" => [
        "main" => "Gestion des dairas (Code wilaya : :code)"
    ]
],
"occupation_fields" => [
    'name' => "Domaines professionnels",
    "titles" => [
        "main" => "Gérer les domaines professionnels"
    ]
],
"establishment_admin_space" => [
    'name' => "Administration d'Établissement",
    "titles" => [
        "main" => "Tableau de bord d'administration"
    ]
],

"appointments_location_admin_space" => [
    'name' => "Administration des lieux de rendez-vous",
    "titles" => [
        "main" => "Tableau de bord d'administration des lieux de rendez-vous"
    ]
],
"service_admin_space" => [
    'name' => "Administration des services",
    "titles" => [
        "main" => "Tableau de bord d'administration des services"
    ]
],
"manage_appointments_location_admins" => [
    'name' => "Gérer les lieux de rendez-vous",
    "titles" => [
        "main" => "Tableau de bord des lieux de rendez-vous"
    ]
],

"doctor_space" => [
    'name' => "Espace Médecin",
    "titles" => [
        "main" => "Bienvenue Docteur"
    ]
],
'manage_landing'=>[
    "name"=>"Gérer la page d'accueil",
    "titles"=>[
        "main"=>"Gérer les informations de la page d'accueil"
    ],
],
"general_infos"=>[
    "name"=>"Gérer les informations générales",
    "titles"=>[
        "main"=>"Gérer les informations générales de l'application"
    ],
]
,
'manage_about_us' => [
    'name' => "Gérer la page À propos de nous",
    'titles' => [
        'main' => "Gérer la page À propos de nous"
    ],
],
'manage_our_qualities' => [
    'name' => "Gérer la page Nos qualités",
    'titles' => [
        'main' => "Gérer la page Nos qualités"
    ],
],
'manage_socials' => [
    'name' => 'Page de gestion des réseaux sociaux',
    'titles' => [
        'main' => 'Gérer vos réseaux sociaux',
    ],
],
'messages' => [
    'name' => 'Gérer les messages',
    'titles' => [
        'main' => 'Gérer les messages des visiteurs', // More natural French phrasing
    ],
],
'banks' => [
    'name' => 'Gérer les banques',
    'titles' => [
        'main' => 'Gérer les banques',
    ],
],
'services' => [
    'name' => 'Gérer les services',
    'titles' => [
        'main' => 'Gestion des services',
    ],
],


'articles' => [
    'name' => 'Gérer les articles',
    'titles' => [
        'main' => 'Gestion des articles',
    ],
],

'menus' => [
    'name' => 'Gérer les menus',
    'titles' => [
        'main' => 'Gestion des menus',
    ],
],
'menu' => [
    'name' => 'Gérer le menu',
    'titles' => [
        'main' => 'Gérer les liens externes du menu :title',
    ],
],
'sliders' => [
    'name' => 'Gérer les carrousels',
    'titles' => [
        'main' => 'Gestion des carrousels',
    ],
],
'slider' => [
    'name' => 'Gérer les diapositives',
    'titles' => [
        'main' => 'Gestion des diapositives de :name',
    ],
],
'trends' => [
    'name' => 'Gérer les tendances',
    'titles' => [
        'main' => 'Gestion des tendances',
    ],
],
'establishment' => [
    'name' => 'Détails de :acronym',
    'titles' => [
        'main' => 'Gérer les détails de :acronym',
    ],
],

];
