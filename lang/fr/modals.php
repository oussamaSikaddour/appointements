<?php
 return [
    'our_quality' => [
        'actions' => [
            'new' => "Ajouter une nouvelle qualité",
            'update' => "Mettre à jour la qualité sélectionnée"
        ]
        ],

'message' => [
    'actions' => [
        'reply' => 'Envoyer une réponse',
    ],
],
'user' => [
    'actions' => [
'add' => [
    "user" => "Créer un compte utilisateur",
    "personnel" => "Ajouter du personnel - Établissement : :name"
],
'update' => [
    "user" => "Mettre à jour l'utilisateur : :name",
    "personnel" => "Mettre à jour le personnel : :name"
],
        'manage' => [
            'roles' => 'Gérer les rôles de :name',
            'occupations' => 'Gérer les occupations de :name',
            'banking_information' => 'Gérer les coordonnées bancaires de :name',
        ],
    ],
],

'field' => [
    'actions' => [
        'add' => 'Créer un nouveau domaine professionnel',
        'update' => 'Mettre à jour le domaine : :acronym',
        'manage' => [
            'grades' => 'Gérer les niveaux de grade',
            'specialties' => 'Gérer les spécialisations',
        ],
    ],
],
'wilaya' => [
    'actions' => [
        'add' => 'Ajouter une nouvelle wilaya',
        'update' => 'Mettre à jour la wilaya : :code',
        'manage' => [
            'view' => 'Voir les détails de la wilaya',
        ],
    ],
],
'daira' => [
    'actions' => [
        'add' => 'Ajouter une nouvelle daïra',
        'update' => 'Mettre à jour la daïra : :code',
    ],
],
'bank' => [
    'actions' => [
        'add' => 'Ajouter une nouvelle banque',
        'update' => 'Mettre à jour la banque sélectionnée',
    ],
],
'service' => [
    'actions' => [
        'add' => 'Ajouter un nouveau service',
        'update' => 'Mettre à jour le service sélectionné',
        "manage_coordinators" => "Gérer les coordinateurs de :name",
    ],
],
'menu' => [
    'actions' => [
        'add' => 'Ajouter un nouveau menu',
        'update' => 'Mettre à jour le menu sélectionné',
    ],
],
'external_link' => [
    'actions' => [
        'add' => 'Ajouter un nouveau lien externe',
        'update' => 'Mettre à jour le lien externe sélectionné',
    ],
],
'slider' => [
    'actions' => [
        'add' => 'Ajouter un nouveau slider',
        'update' => 'Mettre à jour le slider sélectionné',
    ],
],
'slide' => [
    'actions' => [
        'add' => 'Ajouter une nouvelle diapositive',
        'update' => 'Mettre à jour la diapositive sélectionnée',
    ],
],
'article' => [
    'actions' => [
        'add' => 'Ajouter un nouvel article',
        'update' => 'Mettre à jour l’article sélectionné',
    ],
],
'trend' => [
    'actions' => [
        'add' => 'Ajouter une nouvelle tendance',
        'update' => 'Mettre à jour la tendance sélectionnée',
    ],
],

'establishment' => [
    'actions' => [
        'add' => 'Créer un nouvel établissement',
        'update' => 'Mettre à jour l\'établissement : :acronym',
    ],
],

'schedule' => [
    'actions' => [
        'add' => 'Créer un nouvel planning',
        'update' => 'Modifier le planning :name',
        "manage" => 'Gérer les dates du planning ":name"',
    ],
],
'medical_file' => [
    "actions" => [
        "add" => "Créer un dossier médical",
        "update" => 'Modifier le dossier médical code : " :code" '
    ]
],
"appointment" => [
    "instruction" => "Sélectionnez la spécialité pour afficher les dates disponibles",
    "actions" => [
        "add" => [
            "simple" => "Prendre un rendez-vous médical spécialisé",
            "initial" => "Prendre un rendez-vous médical spécialisé pour le Patient : :code",
            "follow-up" => "Prendre un suivi pour le Patient : :code",
        ],
        "update" => "Modifier le rendez-vous du Patient : :code"
    ],
    "errors" => [
    'too_close_to_cancel' => 'Vous ne pouvez pas annuler ce rendez-vous car il a lieu dans moins de 3 jours.',
],
],
"patient_visit" => [
    "actions" => [
        "add" => [
            "simple" => "Ajouter un Rapport de Consultation",
            "detailed" => "Ajouter un Rapport de Consultation du Patient :code"
        ],
        'update' => "Modifier le Rapport de Consultation du Patient :code",
        "manage" => [
            "images" => "Gérer les Documents de Visite du Patient :name (Format Image)",
            "files" => "Gérer les Documents de Visite du Patient :name (Format PDF)",
        ]
    ]
],
 ];
