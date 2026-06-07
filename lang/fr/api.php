<?php

return [
"common" => [
    "errors" => [
        "lang" => "Veuillez vérifier le segment d'URL suivant 'api/' et assurer qu'il spécifie l'une des langues: fr, ar ou en",
        'deactivated_account' => "Votre compte a été désactivé. Veuillez le réactiver ou contacter votre administrateur",
    ]
],
"responses" => [
    "maintenance" => "L'application est actuellement en maintenance. Veuillez réessayer ultérieurement.",
    "logout" => "Vous avez été déconnecté avec succès.",
    "logout_all_devices" => "Vous avez été déconnecté avec succès de tous vos appareils.",
    'account_activated' => "Votre compte a été activé avec succès. Bon retour parmi nous !",
    'account_deactivated' => "Votre compte a été désactivé avec succès. Nous espérons vous revoir bientôt.",
],
"change_email" => [
    "errors" => [
        "old_email" => "L'adresse email que vous avez saisie ne correspond pas à votre email actuel.",
        "new_email" => "La nouvelle adresse email doit être différente de votre adresse actuelle."
    ]
    ],
"users" => [
    "responses" => [
        "bulk_insert_success" => "Toutes les personnes ont été ajoutées avec succès.",
        "destroy" => "Votre compte a été supprimé avec succès."
    ],
    "errors" => [
        "update" => [
            "no-access" => "Vous ne pouvez pas mettre a jour ce compte. Seul le propriétaire du compte peut effectuer cette action."
        ],
        "destroy" => [
            "no-access" => "Vous ne pouvez pas supprimer ce compte. Seul le propriétaire du compte peut effectuer cette action."
        ]
    ]
        ],
"occupations" => [
    "responses" => [
        "destroy" => "La profession a été supprimée avec succès."
    ],
        "errors" => [
    "not-belong" => "Cette profession n'appartient pas à l'utilisateur sélectionné."
    ],
],
"banking_information" => [
    "responses" => [
        "destroy" => "Les informations bancaires ont été supprimées avec succès."
    ],
    "errors" => [
    "not-found" => "Le propriétaire du compte est introuvable."
      ]
],

"medical_file" => [
    "responses" => [
        'unauthorized_delete' => "Seul le propriétaire du dossier médical peut le supprimer",
        "destroy" => "Le dossier médical a été supprimé avec succès"
    ],
    "errors" => [
        "not-found" => "Le propriétaire du dossier médical n'a pas pu être trouvé"
    ]
],
];
