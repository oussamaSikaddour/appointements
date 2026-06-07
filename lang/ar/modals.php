<?php
 return [
    'our_quality' => [
        'actions' => [
            'new' => "إضافة ميزة جديدة",
            'update' => "تحديث الميزة المحددة"
        ]
        ],
    'message' => [
    'actions' => [
        'reply' => 'أرسل رداً',
    ],
],

'user' => [
    'actions' => [
'add' => [
    "user" => "إنشاء حساب مستخدم",
    "personnel" => "إضافة موظف - المنشأة: :name"
],
'update' => [
    "user" => "تحديث المستخدم: :name",
    "personnel" => "تحديث الموظف: :name"
],
        'manage' => [
            'roles' => 'إدارة صلاحيات :name',
            'occupations' => 'إدارة مهن :name',
            'banking_information' => 'إدارة المعلومات البنكية لـ :name',
        ],
    ],
],
'field' => [
    'actions' => [
        'add' => 'إنشاء مجال مهني جديد',
        'update' => 'تحديث المجال: :acronym',
        'manage' => [
            'grades' => 'إدارة مستويات الدرجات',
            'specialties' => 'إدارة التخصصات',
        ],
    ],
],

'wilaya' => [
    'actions' => [
        'add' => 'إضافة ولاية جديدة',
        'update' => 'تحديث الولاية: :code',
        'manage' => [
            'view' => 'عرض تفاصيل الولاية',
        ],
    ],
],
'daira' => [
    'actions' => [
        'add' => 'إضافة دائرة جديدة',
        'update' => 'تحديث الدائرة: :code',
    ],
],
'bank' => [
    'actions' => [
        'add' => 'إضافة بنك جديد',
        'update' => 'تحديث البنك المحدد',
    ],
],
'service' => [
    'actions' => [
        'add' => 'إضافة خدمة جديدة',
        'update' => 'تحديث الخدمة المحددة',
       "manage_coordinators" => "إدارة منسقي :name",
    ],
],
'menu' => [
    'actions' => [
        'add' => 'إضافة قائمة جديدة',
        'update' => 'تحديث القائمة المحددة',
    ],
],
'external_link' => [
    'actions' => [
        'add' => 'إضافة رابط خارجي جديد',
        'update' => 'تحديث الرابط الخارجي المحدد',
    ],
],
'slider' => [
    'actions' => [
        'add' => 'إضافة سلايدر جديد',
        'update' => 'تحديث السلايدر المحدد',
    ],
],
'slide' => [
    'actions' => [
        'add' => 'إضافة شريحة جديدة',
        'update' => 'تحديث الشريحة المحددة',
    ],
],
'article' => [
    'actions' => [
        'add' => 'إضافة مقال جديد',
        'update' => 'تحديث المقال المحدد',
    ],
],
'trend' => [
    'actions' => [
        'add' => 'إضافة توجه جديد',
        'update' => 'تحديث التوجه المحدد',
    ],
],
'establishment' => [
    'actions' => [
        'add' => 'إضافة مؤسسة جديدة',
        'update' => 'تحديث المؤسسة: :acronym',
    ],
],

'schedule' => [
    'actions' => [
        'add' => 'إنشاء جدول جديد',
        'update' => 'تحديث الجدول :name',
        "manage" => 'إدارة مواعيد الجدول ":name"',
    ],
],
'medical_file' => [
    "actions" => [
        "add" => "إنشاء ملف طبي",
        "update" => 'تحديث الملف الطبي رقم : " :code" '
    ]
],
"appointment" => [
    "instruction" => "اختر التخصص الطبي على الأقل لرؤية التواريخ المتاحة",
    "actions" => [
        "add" => [
            "simple" => "حجز موعد طبي متخصص",
            "initial" => "حجز موعد طبي متخصص للمريض : :code",
            "follow-up" => "حجز متابعة للمريض : :code",
        ],
        "update" => "تحديث موعد المريض : :code"
    ],
    "errors" => [
    'too_close_to_cancel' => 'لا يمكنك إلغاء هذا الموعد لأنه سيتم خلال أقل من 3 أيام.',
],
],
"patient_visit" => [
    "actions" => [
        "add" => [
            "simple" => "إضافة تقرير استشارة",
            "detailed" => "إضافة تقرير استشارة المريض :code"
        ],
        'update' => "تحديث تقرير استشارة المريض :code",
        "manage" => [
            "images" => "إدارة مستندات زيارة المريض :name (صيغة الصورة)",
            "files" => "إدارة مستندات زيارة المريض :name (صيغة PDF)",
        ]
    ]
],
 ];
