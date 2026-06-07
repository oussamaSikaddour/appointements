<?php
return [
    "common" => [
        "excel-file-type-err" => "Le fichier doit être au format Excel (XLSX, XLS, CSV)",
        'actions' => 'Actions',
        'perPage' => 'Par page',
    ],

    'our_qualities' => [
        'info' => 'Liste de nos qualités',
        'not_found' => 'Aucune qualité trouvée pour le moment',
        'created_at' => 'Date d\'ajout',
        'name' => 'Nom',
        'status' => 'Statut',
        'errors' => [
            'active_limit' => 'Seules 4 qualités peuvent être actives pour être affichées aux visiteurs du site web',
        ],
    ],
    'messages' => [
        'info' => 'Messages des visiteurs',
        'not_found' => 'Aucun message de visiteur trouvé pour le moment',  // More natural
        'name' => 'Nom',
        'email' => 'Email',
        'created_at' => 'Date de réception', // More natural
    ],
'users' => [
    "info" => [
        'default' => 'Registre du personnel',
        "establishment" => "Annuaire du personnel - Établissement : :acronym",
        "service" => "Annuaire du personnel - Service : :acronym"
    ],
    "empty" => [
        'default' => "Aucun personnel enregistré",
        "establishment" => "Aucun personnel affecté à cet établissement",
        "service" => "Aucun personnel affecté à ce service"
    ],
    'establishment' => "Établissement assigné",
    'service' => "Service assigné",
    "full_name" => "Nom complet",
    "full_name_fr" => "Nom (Français)",
    "full_name_ar" => "Nom (Arabe)",
    "employee_number" => "Matricule",
    "social_number" => "Numéro de sécurité sociale",
    "email" => "Email officiel",
    "registration_date" => "Date d'enregistrement",
    "phone" => "Numéro de contact",
    "card_number" => "Numéro de carte nationale",
    "birth_date" => "Date de naissance",
    "birth_place_fr" => "Lieu de naissance (Français)",
    "birth_place_ar" => "Lieu de naissance (Arabe)",
    "birth_place_en" => "Lieu de naissance (Anglais)",
    "excel" => [
        "upload" => [
            "success" => "Données du personnel importées avec succès"
        ]
    ]
],

'wilayates' => [
    "info" => "Répertoire des wilayas",
    "not_found" => "Aucune wilaya disponible actuellement",
    "code" => "Code de wilaya",
    "designation" => "Nom de wilaya",
    "designation_fr" => "Nom français",
    "designation_ar" => "Nom arabe",
    "designation_en" => "Nom anglais",
    "registration_date" => "Date d'enregistrement",
    "excel" => [
        "upload" => [
            "success" => "Données des wilayas importées avec succès"
        ]
    ]
],
'dairates' => [
    "info" => "Dairas de la wilaya (Code : :code)",
    "not_found" => "Aucune daïra disponible actuellement",
    "code" => "Code de daïra",
    "designation" => "Nom de daïra",
    "designation_fr" => "Nom français",
    "designation_ar" => "Nom arabe",
    "designation_en" => "Nom anglais",
    "registration_date" => "Date d'enregistrement",
    "excel" => [
        "upload" => [
            "success" => "Données des daïras importées avec succès"
        ]
    ]
],
'communes' => [
    "info" => "Communes de la daïra (Code : :code)",
    "not_found" => "Aucune commune disponible actuellement",
    "code" => "Code de commune",
    "designation" => "Nom de commune",
    "designation_fr" => "Nom français",
    "designation_ar" => "Nom arabe",
    "designation_en" => "Nom anglais",
    "registration_date" => "Date d'enregistrement",
    "excel" => [
        "upload" => [
            "success" => "Données des communes importées avec succès"
        ]
    ]
],
'fields' => [
    "info" => "Répertoire des domaines",
    "not_found" => "Aucun domaine disponible actuellement",
    "acronym" => "Acronyme",
    "designation" => "Désignation principale",
    "designation_fr" => "Désignation française",
    "designation_ar" => "Désignation arabe",
    "designation_en" => "Désignation anglaise",
    "registration_date" => "Date d'enregistrement",
    "excel" => [
        "upload" => [
            "success" => "Domaines importés avec succès"
        ]
    ]
],
'field_grades' => [
    "info" => "Niveaux de grade pour le domaine : :acronym",
    "not_found" => "Aucun niveau de grade disponible actuellement",
    "acronym" => "Code de grade",
    "designation" => "Intitulé du grade",
    "designation_fr" => "Intitulé français",
    "designation_ar" => "Intitulé arabe",
    "designation_en" => "Intitulé anglais",
    "registration_date" => "Date d'enregistrement",
    "excel" => [
        "upload" => [
            "success" => "Niveaux de grade importés avec succès"
        ]
    ]
],
'field_specialties' => [
    "info" => "Spécialisations professionnelles: :acronym",
    "not_found" => "Aucune spécialité disponible actuellement",
    "acronym" => "Code de spécialité",
    "designation" => "Intitulé de spécialisation",
    "designation_fr" => "Intitulé français",
    "designation_ar" => "Intitulé arabe",
    "designation_en" => "Intitulé anglais",
    "registration_date" => "Date d'enregistrement",
    "excel" => [
        "upload" => [
            "success" => "Spécialisations importées avec succès"
        ]
    ]
],
'occupations' => [
    'info' => 'Liste des occupations',
    'info_custom' => 'Liste des occupations de :name',
    'not_found' => 'Aucune occupation trouvée pour le moment',
    'is_active' => 'État',
    'entitled' => 'Intitulé',
    'field' => 'Domaine',
    'experience' => 'Expérience',
    'specialty' => 'Spécialité',
    'grade' => 'Grade',
    'created_at' => 'Ajouté le',
],
'banking_information' => [
    'info' => 'Liste des informations bancaires',
    'info_custom' => ' :name Informations bancaires',
    'not_found' => 'Aucune information bancaire trouvée pour le moment',
    'bank_acronym' => 'Banque',
    'agency' => 'Agence',
    'agency_code' => 'Code agence',
    'account_number' => 'Numéro de compte',
    'is_active' => 'État',
    'created_at' => 'Ajouté le',
],

'banks' => [
    "info" => "Répertoire des banques",
    "not_found" => "Aucune banque disponible actuellement",
    'code' => "Code banque",
    'acronym' => "Sigle de la banque",
    "designation" => "Nom de la banque",
    "designation_fr" => "Nom français",
    "designation_ar" => "Nom arabe",
    "designation_en" => "Nom anglais",
    "created_at" => "Date d'enregistrement",
],
'menus' => [
    "info" => "Liste des menus",
    "not_found" => "Aucun menu trouvé pour le moment",
    "title" => "Titre",
    "state" => "État",
    "type" => "Type",
    "created_at" => "Ajouté le",
],
'external_links' => [
    "info" => "Liste des liens externes",
    "not_found" => "Aucun lien externe trouvé pour le moment",
    "name" => "Nom",
    "url" => "URL",
    "created_at" => "Ajouté le",
],

'articles' => [
    "info" => "Liste des articles",
    "not_found" => "Aucun article trouvé pour le moment",
    "created_at" => "Ajouté le",
    'author' => "Auteur",
    'title' => "Titre",
    "articleable_type" => "Publié pour",
    "articleable_id" => "Publié dans",
    "location" => "Emplacement",
    "state" => "État",
],
    'sliders' => [
        "info" => "Liste des sliders",
        "not_found" => "Aucun slider trouvé pour le moment",
        "created_at" => "Ajouté le",
        "creator" => "Créateur",
        "name" => "Nom",
        "sliderable_type" => "Publié pour",
        "sliderable_id" => "Publié dans",
        "location" => "Emplacement",
        "state" => "État",
    ],

'establishments' => [
    "info" => "Répertoire des établissements",
    "not_found" => "Aucun établissement enregistré actuellement",
    "created_at" => "Date d'enregistrement",
    "acronym" => "Code d'établissement",
    "name" => "Nom officiel",
    "name_fr" => "Nom français",
    "name_ar" => "Nom arabe",
    "name_en" => "Nom anglais",
    "email" => "Email officiel",
    "address" => "Adresse complète",
    "description" => "Description",
    "tel" => "Téléphone principal",
    "fax" => "Fax",
    'daira' => "District administratif",
    'longitude' => "Longitude",
    'latitude' => "Latitude",
    'capacity' => "Capacité maximale",
    "excel" => [
        "upload" => [
            "success" => "Établissements importés avec succès"
        ]
    ]
],

'services' => [
    "info" => "Liste des services de l'établissement",
    "not_found" => "Aucun service actuellement enregistré",
    "created_at" => "Date d'enregistrement",
    "name" => "Nom du service",
    "name_fr" => "Nom du service (Français)",
    "name_en" => "Nom du service (Anglais)",
    "name_ar" => "Nom du service (Arabe)",
    "tel" => "Téléphone principal",
    "fax" => "Fax",
    "head_service" => "Chef de service",
    "establishment" => "Établissement parent",
    "type" => "Type de service",
    "specialty" => "Spécialité médicale",
    "excel" => [
        "upload" => [
            "success" => "Services importés avec succès"
        ]
    ]
],
'coordinators' => [
    "name" => "Nom",
    "employee_number" => "Matricule",
    "email" => "Email officiel",
    "registration_date" => "Date d'enregistrement",
    "phone" => "Numéro de téléphone",
],
"appointments_location_admins" => [
    "name" => "Nom",
    "employee_number" => "Matricule",
    "email" => "Email officiel",
    "registration_date" => "Date d'enregistrement",
    "phone" => "Numéro de téléphone",
],
"available_appointments" => [
    "info" => [
        "follow-ups" => "Rendez-vous de suivi pour le patient : :code",
        "initials" => "Rendez-vous disponibles - Veuillez sélectionner la date souhaitée",
    ],
    "not_found" => "Aucun rendez-vous disponible actuellement. Veuillez vérifier les informations du formulaire ou réessayer ultérieurement",
    "date_at" => "Date du rendez-vous",
    "daira" => "Daïra",
    "doctor" => "Médecin assigné",
    "appointments_location" => "Lieu du rendez-vous",
],
"confirmed_appointments" => [
   "info" => "Rendez-vous Confirmés",
    "not_found" => "Aucun rendez-vous disponible actuellement. Veuillez vérifier les filtres ou réessayer ultérieurement",
    "queue_number" => "Numéro de file d'attente",
    "patient" => "Nom du Patient",
    "patient_code" => "Code Patient",
    "patient_birth_date" => "Date de Naissance",
    "patient_tel" => "Téléphone",
    "year" => "Année",
    "month" => "Mois",
    "specialty" => "Spécialité",
    "doctor" => "Médecin",
    "doctor_name" => "Médecin",
    'daira' => "Daïra",
    "location" => "Lieu de Rendez-vous",
    "schedule_day" => "Date de Rendez-vous",
    "date" => "Date de Rendez-vous",
    "type" => "Type",
    "referral_letter" => "Lettre d'Orientation"
],
'medical_files' => [
    "info" => "Dossiers médicaux de mes proches",
    "not_found" => "Aucun dossier médical disponible pour le moment",
    "code" => "Code",
    'name' => "Nom",
    'year' => "Année",
    "last_name_fr" => "Nom de famille (Fr)",
    "last_name_ar" => "Nom de famille (Ar)",
    "first_name_fr" => "Prénom (Fr)",
    "first_name_ar" => "Prénom (Ar)",
    "insurance_number" => "Numéro d'assurance",
    'gender' => "Genre",
    "birth_date" => "Date de naissance",
    "tel" => "Numéro de téléphone",
    'created_at' => "Date de création du dossier"
],
'ratings' => [
    "info" => "Évaluations des patients pour le Dr. :doctor",
    "not_found" => "Aucune évaluation patient disponible pour le moment",
    'doctor' => "Médecin",
    'user_id' => "Patient",
    'rating' => "Score de satisfaction (1-5)",
    'created_at' => "Date d'évaluation"
],
'schedules' => [
    "info" => "Listes des Planning du service",
    "not_found" => "Aucun Planning trouvé",
    "year" => "Année",
    "month" => "Mois",
    "name" => "Désignation",
    "name_fr" => "Désignation (Fr)",
    "name_en" => "Désignation (En)",
    "name_ar" => "Désignation (Ar)",
    "state" => "Statut de publication",
     "created_at"=>"Date de création",
    "service" => "Service médical noté",
    "created_by" => "Créé par"
],
'schedule_days' => [
    "info" => 'Listes des dates du planning ":name"',
    "not_found" => "Aucune date trouvée pour le moment",
    'doctor' => "Médecin",
    "specialty" => "Spécialité",
    'day_at' => "Date du rendez-vous",
    'available_number' => "Rendez-vous disponibles",
    'confirmed_number' => "Rendez-vous confirmés",
    'state' => "Disponibilité du planning",
    'appointment_location' => "Lieu de rendez-vous"
],
'visits' => [
    "info" => "Dossiers de Visite des Patients",
    "not_found" => "Aucun dossier de visite trouvé",
    'appointment' => "Référence de rendez-vous",
    "code" => "ID Patient",
    'patient' => "Nom du patient",
    'doctor' => "Médecin traitant",
    "date" => "Date de consultation"
],
'images' => [
    "info" => "Liste des Fichiers Image",
    "not_found" => "Aucun Fichier Image Trouvé",
    'display_name' => "Nom d'Affichage",
    "use_case" => "Cas d'Utilisation",
    'created_at' => "Ajouté Le",
    'preview' => "Aperçu",
],
'files' => [
    "info" => "Liste des Fichiers PDF",
    "not_found" => "Aucun Fichier PDF Trouvé",
    'display_name' => "Nom d'Affichage",
    "use_case" => "Cas d'Utilisation",
    'created_at' => "Ajouté Le",
    'preview' => "Aperçu",
    "download" => "Télécharger le Fichier"
],
];
