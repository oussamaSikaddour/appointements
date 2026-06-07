<?php

return [
'common' => [
    'actions' => [
        'submit' => 'Soumettre',
        'reset' => 'Réinitialiser le formulaire',
    ],
    'errors' => [
        "default"=>"Une erreur s'est produite. Veuillez contacter votre équipe informatique.",
        "not_match"=>[
            'phone' => 'Le numéro de téléphone doit commencer par 05, 06 ou 07 et contenir exactement 10 chiffres.',
            "land_line"=>"Le numéro de téléphone fixe doit commencer par 0 et contenir exactement 9 chiffres"
        ],
        'img' => [
            'not_img' => 'Le fichier doit être une image.',
            "not_imgs"=>"Les fichiers doivent être des images",
        ],
        'user' => [
            'not_exists' => 'Le champ :attribute est requis.',
        ],
    ],
],
'site_parameters' => [
    'steps' => [
        'first' => [
            'password' => 'Mot de passe',
            'email' => 'Votre adresse électronique',
        ],
        'last' => [
            'state' => "État",
            'enable' => "Activer",
            'disable' => "Désactiver",
        ],
    ],
"actions"=>[
    "download_db"=>"Télécharger la base de données"
],
    'responses' => [
        'you_can_pass' => 'Vous avez les informations d\'identification nécessaires pour mettre à jour l\'état de l\'application.',
        'success' => 'Vous avez mis à jour avec succès l\'état de l\'application.',
    ],
    'errors' => [
        'no_access' => 'Vous n\'avez pas les informations d\'identification nécessaires pour passer à l\'étape suivante.',
        'user_not_found' => 'Vérifiez votre adresse électronique et votre mot de passe, puis réessayez.',
    ],
],

    'login' => [
        'email' => 'Votre Email',
        'password' => 'Votre Mot de passe',
        'actions' => [
            'submit' => 'Se connecter',
        ],
        'responses' => [
            'success' => 'Vous êtes connecté avec succès.',
        ],
        'errors' => [
            'too_many_attempts' => 'Trop de tentatives de connexion. Veuillez réessayer plus tard.',
            'invalid_credentials' => "Les informations d'identification fournies sont invalides.",
        ],
    ],

    'register' => [
        'instructions' => [
            'email' => 'L\'adresse email doit être valide. Un code de vérification vous sera envoyé.',
            'code' => 'Entrez le code envoyé à votre email.',
        ],
        'email' => 'Votre Email',
        'steps' => [
            'first' => [
                'password' => 'Mot de passe',
            ],
            'last' => [
                'code' => 'Code de vérification',
            ],
        ],
        'actions' => [
            'get_code' => 'Envoyer le code',
            'get_new_code' => 'Envoyer un nouveau code',
            'submit' => 'S\'inscrire',
        ],
        'responses' => [
            'new_code' => 'Un nouveau code de vérification a été envoyé à votre email.',
            'success' => 'Vous vous êtes inscrit avec succès.',
        ],
        'errors' => [
            'verification_code' => 'Le code de vérification est incorrect ou a expiré.',
        ],
    ],

    'forgot_password' => [
        'instructions' => [
            'email' => 'L\'adresse email doit être valide. Un code de vérification vous sera envoyé.',
            'code' => 'Entrez le code envoyé à votre email.',
        ],
        'email' => 'Votre Email',
        'steps' => [
            'last' => [
                'code' => 'Code de vérification',
                'password' => 'Nouveau mot de passe',
            ],
        ],
        'actions' => [
            'get_code' => 'Envoyer le code',
        ],
        'responses' => [
            'new_code' => 'Un nouveau code de vérification a été envoyé à votre email.',
            'success' => 'Vous avez récupéré votre compte avec succès.',
        ],
        'errors' => [
            'no_user' => 'Aucun utilisateur trouvé avec cet email. Veuillez vérifier et réessayer.',
            'verification_code' => 'Le code de vérification est incorrect ou a expiré.',
        ],
    ],
    'change_password' => [
        'infos' => [
            'redirect' => 'Après avoir modifié votre mot de passe, vous serez déconnecté.',
        ],
        'old_pwd' => 'Votre ancien mot de passe',
        'pwd' => 'Votre nouveau mot de passe',
        'responses' => [
            'success' => 'La modification a été effectuée avec succès. Vous allez être déconnecté maintenant.',
        ],
        'errors' => [
            'old_pwd' => 'Veuillez vérifier votre ancien mot de passe et réessayer.',
            'invalid_current' => "Password modification is restricted to Super Administrators and the account owner",
        ],
    ],
'change_mail' => [
    'infos' => [
        'redirect' => 'Vous serez déconnecté après avoir modifié votre adresse électronique.',
    ],
    'pwd' => 'Mot de passe',
    'mail' => 'Adresse électronique actuelle',
    'new_mail' => 'Nouvelle adresse électronique',
    'responses' => [
        'success' => 'Votre adresse électronique a été modifiée avec succès. Vous allez maintenant être déconnecté.',
    ],
    'errors' => [
        'auth' => 'Veuillez vérifier votre adresse électronique et votre mot de passe actuels et réessayer.',
    ],
],
'general_infos' => [

    'email' => "Email",
    'logo'=>"Logo",
    'phone'=>"Téléphone",
    'landline'=>"Téléphone fixe",
    'fax'=>"Fax",
    'map'=>"Google Map",
    'responses' => [
        'success' => 'Vous avez mis à jour avec succès les informations générales de votre application',
    ],

],
'manage_hero' => [
    'title_ar' => "Titre en arabe",
    'title_fr' => "Titre en français",
    'title_en' => "Titre en anglais",
    'sub_title_ar' => "Sous-titre en arabe",
    'sub_title_fr' => "Sous-titre en français",
    'sub_title_en' => "Sous-titre en anglais",
    "images" => "Images de la page d'accueil",
    'responses' => [
        'success' => "Vous avez mis à jour avec succès les informations de la page d'accueil de votre application",
    ],
],
'manage_about_us' => [
    'title_ar' => "Titre en arabe",
    'title_fr' => "Titre en français",
    'title_en' => "Titre en anglais",
    'description_ar' => "Description en arabe",
    'description_fr' => "Description en français",
    'description_en' => "Description en anglais",
    "image" => "Image de la page À propos de nous",
    'responses' => [
        'success' => "Vous avez mis à jour avec succès les informations de la page À propos de nous de votre application",
    ],
],
'our_quality' => [
    'name_ar' => "Titre en arabe",
    'name_fr' => "Titre en français",
    'name_en' => "Titre en anglais",
    "image" => "Image",
    'responses' => [
        'add_success' => "Vous avez ajouté avec succès une nouvelle qualité",
        'update_success' => "Vous avez mis à jour avec succès la qualité sélectionnée",
    ],
],
'socials' => [
    'youtube' => 'YouTube',
    'facebook' => 'Facebook',
    'github' => 'GitHub',
    'linkedin' => 'LinkedIn',
    'instagram' => 'Instagram',
    'tiktok' => 'TikTok',
    'responses' => [
        'success' => 'Vos réseaux sociaux ont été mis à jour avec succès', // More natural French phrasing
    ],
],

"user" => [
    'instructions' => [
        "email" => "Un email valide est requis. Un code de vérification y sera envoyé.",
    ],
    'email' => "Adresse email",
    "last_name_fr" => "Nom de famille (Français)",
    "last_name_ar" => "Nom de famille (Arabe)",
    "first_name_fr" => "Prénom (Français)",
    "first_name_ar" => "Prénom (Arabe)",
    "profile_img" => "Photo de profil",
    'is_paid' => 'Statut de paiement',
    'is_active' => 'Statut actif',
    "cv" => "Curriculum Vitae",
    "card_number" => "Numéro de carte nationale",
    "birth_date" => "Date de naissance",
    'birth_place_fr' => "Lieu de naissance (Français)",
    'birth_place_ar' => "Lieu de naissance (Arabe)",
    "address_fr" => "Adresse (Français)",
    "address_ar" => "Adresse (Arabe)",
    "address_en" => "Adresse (Anglais)",
    'phone' => "Numéro de téléphone",
    "employee_number" => "Matricule",
    "social_number" => "Numéro de sécurité sociale",
    'responses' => [
       "add" => [
        "user" => "Compte utilisateur créé avec succès",
        "personnel" => "Fiche personnel ajoutée avec succès",
       ],
       "update" => [
        "user" => "Compte utilisateur mis à jour : :name",
        "personnel" => "Fiche personnel mise à jour : :name",
       ],
    ],
],
'role' => [
    'errors' => [
        'user_id_required' => 'La sélection d\'un utilisateur est requise',
        'user_id_exists'   => 'Le compte utilisateur spécifié n\'existe pas',
        'roles_required'   => 'Au moins un rôle doit être sélectionné',
        'roles_array'      => 'Les rôles doivent être fournis sous forme d\'identifiants valides',
        'roles_exist'      => 'Un ou plusieurs rôles spécifiés sont invalides',
        'user_not_found'   => 'Le compte utilisateur demandé n\'a pas été trouvé',
        'error_title'      => 'Erreur d\'Attribution des Rôles',
    ],
    'responses' => [
        'success'      => 'Les rôles utilisateur ont été mis à jour avec succès',
        'own_success'  => 'Vos rôles ont été mis à jour. Pour des raisons de sécurité, vous avez été déconnecté de toutes les sessions.',
    ],
],

"wilaya" => [
    'designation_fr' => "Nom français",
    'designation_ar' => "Nom arabe",
    'designation_en' => "Nom anglais",
    'code' => "Code de wilaya",
    'responses' => [
        'add_success' => 'Wilaya créée avec succès',
        'update_success' => 'Wilaya mise à jour avec succès',
    ],
],
"daira" => [
    'designation_fr' => "Nom français",
    'designation_ar' => "Nom arabe",
    'designation_en' => "Nom anglais",
    'code' => "Code de daïra",
    'responses' => [
        'add_success' => 'Daïra créée avec succès',
        'update_success' => 'Daïra mise à jour avec succès',
    ],
],
"commune" => [
    'designation_fr' => "Nom français",
    'designation_ar' => "Nom arabe",
    'designation_en' => "Nom anglais",
    'code' => "Code de commune",
    'responses' => [
        'add_success' => 'Commune créée avec succès',
        'update_success' => 'Commune mise à jour avec succès',
    ],
],
"field" => [
    'designation_fr' => "Désignation française",
    'designation_ar' => "Désignation arabe",
    'designation_en' => "Désignation anglaise",
    'acronym' => "Acronyme",
    'responses' => [
        'add_success' => 'Domaine professionnel créé avec succès',
        'update_success' => 'Domaine mis à jour avec succès',
    ],
],
"field_grade" => [
    'designation_fr' => "Désignation française",
    'designation_ar' => "Désignation arabe",
    'designation_en' => "Désignation anglaise",
    'acronym' => "Code de grade",
    'field_id' => "Domaine professionnel",
    'responses' => [
        'add_success' => 'Niveau de grade créé avec succès',
        'update_success' => 'Niveau de grade mis à jour avec succès',
    ],
],
"field_specialty" => [
    'designation_fr' => "Désignation française",
    'designation_ar' => "Désignation arabe",
    'designation_en' => "Désignation anglaise",
    'acronym' => "Code de spécialité",
    'field_id' => "Domaine professionnel",
    'responses' => [
        'add_success' => 'Spécialité professionnelle créée avec succès',
        'update_success' => 'Spécialité mise à jour avec succès',
    ],
],
"occupation" => [
    'field_id' => "Domaine Professionnel",
    'field_specialty_id' => "Spécialisation",
    'field_grade_id' => "Grade Professionnel",
    "description_fr" => "Description Professionnelle (Français)",
    "description_en" => "Description Professionnelle (Anglais)",
    "description_ar" => "Description Professionnelle (Arabe)",
    "experience" => "Années d'Expérience Professionnelle",
    'errors' => [
        'field_required' => 'La sélection du domaine professionnel est requise',
        'field_exists' => 'Le domaine professionnel sélectionné est invalide',
        'field_specialty_exists' => 'La spécialisation sélectionnée est invalide',
        'field_grade_exists' => 'Le grade professionnel sélectionné est invalide',
    ],
    'responses' => [
        'add_success' => 'Occupation professionnelle ajoutée avec succès',
        'update_success' => 'Occupation professionnelle modifiée avec succès',
    ],
],
"banking_information" => [
    "agency_fr" => "Agence Bancaire (Français)",
    "agency_ar" => "Agence Bancaire (Arabe)",
    "agency_en" => "Agence Bancaire (Anglais)",
    "agency_code" => "Code d'Agence",
    "account_number" => "Numéro de Compte",
    "bank_id" => "Institution Financière",
    'errors' => [
        'bankable_id_required' => 'L\'identifiant de l\'entité associée est requis',
        'bankable_type_required' => 'Le type d\'entité associée est requis',
        'bankable_type_invalid' => 'Le type d\'entité spécifié est invalide',
    ],
    'responses' => [
        'add_success' => 'Informations bancaires ajoutées avec succès',
        'update_success' => 'Informations bancaires modifiées avec succès',
    ],
],
"bank" => [
    "acronym" => "Acronyme",
    "designation_ar" => "Désignation en arabe",
    "designation_fr" => "Désignation en français",
    "designation_en" => "Désignation en anglais",
    "code" => "Code",
    'responses' => [
        'add_success' => 'Vous avez ajouté une nouvelle banque avec succès',
        'update_success' => 'Vous avez mis à jour la banque sélectionnée avec succès',
    ],
],

"external_link" => [
    "name_fr" => "Nom en français",
    "name_ar" => "Nom en arabe",
    "name_en" => "Nom en anglais",
    'url' => "Lien URL",
    "menu_id" => "Nom du menu",
    'responses' => [
        'add_success' => 'Vous avez ajouté un nouveau lien externe avec succès',
        'update_success' => 'Vous avez mis à jour le lien externe sélectionné avec succès',
    ],
],
"menu" => [
    'title_fr' => "Titre en français",
    'title_ar' => "Titre en arabe",
    'title_en' => "Titre en anglais",
    "type" => "Type",
    "state" => "État",
    'responses' => [
        'add_success' => 'Vous avez ajouté un nouveau menu avec succès',
        'update_success' => 'Vous avez mis à jour le menu sélectionné avec succès',
    ],
],

'article' => [
    'title_fr' => "Titre en français",
    'title_ar' => "Titre en arabe",
    'title_en' => "Titre en anglais",
    "content_fr" => "Contenu en français",
    "content_en" => "Contenu en anglais",
    "content_ar" => "Contenu en arabe",
    "published_at" => "Date de publication",
    "articleable_type" => "Type de publication",
    "articleable_id" => "Publié dans",
    "images" => "Images",
    'responses' => [
        'add_success' => "Vous avez ajouté un nouvel article avec succès",
        'update_success' => "Vous avez mis à jour l'article sélectionné avec succès",
    ],
],

'slide' => [
        'title_fr' => "Titre en français",
        'title_ar' => "Titre en arabe",
        'title_en' => "Titre en anglais",
        'content_fr' => "Contenu en français",
        'content_en' => "Contenu en anglais",
        'content_ar' => "Contenu en arabe",
        'order' => "Ordre de la diapositive",
        'slider_id' => "Slider",
        'image' => "Image",
        'responses' => [
            'add_success' => 'Vous avez ajouté une nouvelle diapositive avec succès',
            'update_success' => 'Vous avez mis à jour la diapositive sélectionnée avec succès',
        ],
    ],
    "slider" => [
        "name" => "Nom",
        "sliderable_type" => "Type de publication",
        "sliderable_id" => "Publié dans",
        "user_id" => "Éditeur",
        "state" => "État de publication",
        'responses' => [
            'add_success' => 'Vous avez ajouté une nouvelle diapositive avec succès',
            'update_success' => 'Vous avez mis à jour la diapositive sélectionnée avec succès',
        ],
    ],

'trend' => [
    'title_fr' => "Titre en français",
    'title_ar' => "Titre en arabe",
    'title_en' => "Titre en anglais",
    'content_fr' => "Contenu en français",
    'content_en' => "Contenu en anglais",
    'content_ar' => "Contenu en arabe",
    'start_at' => "Du",
    'end_at' => "Jusqu'à",
    'responses' => [
        'add_success' => 'Vous avez ajouté une nouvelle tendance avec succès',
        'update_success' => 'Vous avez mis à jour la tendance sélectionnée avec succès',
    ],
],

'appointment' => [
    "patient_id" => "Patient",
    "schedule_day_id" => "Jour planifié",
    'appointments_location_id' => "Lieu de rendez-vous",
    "type" => "Type de rendez-vous",
    "day_at" => "Date du rendez-vous",
    "status" => "Statut du rendez-vous",
    "specialty_id" => "Spécialité médicale",
    "daira_id" => "District administratif",
    "doctor_id" => "Médecin assigné",
    "referral_letter" => "Lettre d'orientation (Format Image)",
    'responses' => [
        'add_success' => "Nouveau rendez-vous programmé avec succès",
        'update_success' => "Détails du rendez-vous modifiés avec succès",
    ],
    "errors" => [
        "not_found" => [
            "patient" => "La sélection du dossier médical est requise",
            "schedule_day" => "La sélection de la date de rendez-vous est requise",
            "doctor" => "L'assignation d'un médecin est requise"
        ],
        'referral_required' => 'Une lettre d\'orientation est obligatoire pour les consultations initiales',
        "maxed_out" => "Cette date n'est plus disponible. Tous les rendez-vous pour ce jour ont été réservés pendant votre processus de demande",
        "min_gap_days" => "Un délai d'attente minimum de :days jours est requis entre les rendez-vous dans cette spécialité. Date sélectionnée : :date. Rendez-vous précédent : :last"
    ]
],
'establishment' => [
    "acronym" => "Sigle de l'établissement",
    "name_fr" => "Nom de l'établissement (français)",
    "name_ar" => "Nom de l'établissement (arabe)",
    "name_en" => "Nom de l'établissement (anglais)",
    "email" => "Adresse email",
    "address_fr" => "Adresse complète (français)",
    "address_ar" => "Adresse complète (arabe)",
    "address_en" => "Adresse complète (anglais)",
    "description_fr" => "Description de l'établissement (français)",
    "description_ar" => "Description de l'établissement (arabe)",
    "description_en" => "Description de l'établissement (anglais)",
    "tel" => "Numéro de téléphone principal",
    "fax" => "Numéro de fax",
    'capacity' => "Capacité maximale",
    'daira_id' => "District administratif",
    'longitude' => "Longitude",
    'latitude' => "Latitude",
    'responses' => [
        'add_success' => "Nouvel établissement enregistré avec succès",
        'update_success' => "Les informations de l'établissement ont été mises à jour avec succès",
    ],
],
'service' => [
    "name_fr" => "Nom du service (Français)",
    "name_ar" => "Nom du service (Arabe)",
    "name_en" => "Nom du service (Anglais)",
    "specialty" => "Spécialité médicale",
    "type" => "Type de service",
    "tel" => "Téléphone principal",
    "fax" => "Fax",
    "head_of_service_id" => "Chef de service",
    "establishment_id" => "Établissement affilié",

    'responses' => [
        'add_success' => "Service de santé créé avec succès",
        'update_success' => "Service mis à jour avec succès",
    ],
],
"coordinator"=>[
    "user_id"=>"Nom de l'employé",
    'responses' => [
        'add_success' => "Coordinateur ajouté avec succès",
    ],
],
"appointments-location-admin"=>[
    "user_id"=>"Nom de l'employé",
    "appointments_location_id"=>"Lieu de rendez-vous",
    'responses' => [
        'add_success' => "Administrateur du lieu de rendez-vous ajouté avec succès",
    ],
],
'medical_file' => [
    "last_name_fr" => "Nom de famille (Fr)",
    "first_name_fr" => "Prénom (Fr)",
    "last_name_ar" => "Nom de famille (Ar)",
    "first_name_ar" => "Prénom (Ar)",
    'gender' => "Genre",
    "code" => "Code patient",
    "birth_place_fr" => "Lieu de naissance (Fr)",
    "birth_place_ar" => "Lieu de naissance (Ar)",
    "birth_place_en" => "Lieu de naissance (En)",
    "birth_date" => "Date de naissance",
    "address_fr" => "Adresse complète (Fr)",
    "address_ar" => "Adresse complète (Ar)",
    "address_en" => "Adresse complète (En)",
    "tel" => "Numéro de téléphone",
    "opened_by" => "Créé par",
    "insurance_number" => "Numéro de police d'assurance",
    'responses' => [
        'add_success' => "Nouveau dossier médical créé avec succès",
        'update_success' => "Dossier médical modifié avec succès",
    ],
],
'rating' => [
    'doctor_id' => "Médecin",
    'user_id' => "Patient",
    'rating' => "Évaluation (1-5)",
    'comment_fr' => "Commentaire d'évaluation (en français)",
    'comment_ar' => "Commentaire d'évaluation (en arabe)",
    'comment_en' => "Commentaire d'évaluation (en anglais)",

    'responses' => [
        'add_success' => "Nouvelle évaluation soumise avec succès",
        'update_success' => "Votre évaluation a été mise à jour avec succès",
    ],
],
'schedule' => [
    "year" => "Année civile",
    "month" => "Mois",
    "name_fr" => "Nom du Planning (Fr)",
    "name_en" => "Nom du Planning (En)",
    "name_ar" => "Nom du Planning (Ar)",
    "description_fr" => "Description du Planning (Fr)",
    "description_ar" => "Description du Planning (Ar)",
    "description_en" => "Description du Planning (En)",
    "state" => "Statut",
    "service_id" => "Service médical",
    "opened_by" => "Créé par",
    'responses' => [
        'add_success' => "Nouvel horaire créé avec succès",
        'update_success' => "Horaire modifié avec succès",
    ],
    'errors' => [
        'not_found' => [
            'creator'=>"Coordinateur de service requis pour créer un horaire",
            'service'=>"Service requis pour créer un horaire",
        ]
    ],
],
'schedule_day' => [
    'doctor_id' => "Médecin assigné",
    'schedule_id' => "Planning principal",
    'day_at' => "Jour de consultation",
    'available_number' => "Rendez-vous disponibles",
    'state' => "Statut de disponibilité",
    'appointments_location_id' => "Lieu de consultation",

    'responses' => [
        'add_success' => "L'emploi du temps quotidien du médecin a été créé avec succès",
        'update_success' => "L'emploi du temps du médecin a été mis à jour avec succès",
    ],
],
'patient_visit' => [
    'patient_id' => "Patient",
    'doctor_id' => "Médecin",
    'report_fr' => "Rapport Médical (Fr)",
    'report_ar' => "Rapport Médical (Ar)",
    'report_en' => "Rapport Médical (En)",
    'responses' => [
        "add_success" => "Rapport de visite patient ajouté avec succès",
        'update_success' => "Rapport de visite patient modifié avec succès",
    ],
],
'image' => [
    'display_name' => "Nom d'affichage",
    'use_case' => "Cas d'utilisation",
    'real_image' => "Fichier Image",
    'responses' => [
        "add_success" => "Fichier image ajouté avec succès",
        'update_success' => "Fichier image modifié avec succès",
    ],
],
];
