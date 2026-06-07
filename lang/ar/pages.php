<?php
return [
        'index' => [
              'name' => 'صفحة الهبوط',
        ],
        'site_parameters' => [
       'name' => 'معلمات الموقع',
           'titles' => [
                   'main' => 'معلمات الموقع',
                   ],
         ],
        'login' => [
            'name' => 'تسجيل الدخول',
            'links' => [
                'register' => 'جديد في ' . config('app.name') . '؟ انضم الآن ',
                'forgot_password' => 'هل نسيت كلمة المرور ؟',
            ],
            "titles"=>[

                'main' => 'تسجيل الدخول',

                   ]
        ],
    'register' => [
                'name' => 'التسجيل',
                'links' => [
                    'login' => 'هل لديك حساب بالفعل؟',
                ],
                'titles' =>[
                    'main'=> 'إنشاء حساب',
                ]
            ],
'logout' => 'تسجيل الخروج',
 'forgot_password' => [
                'name' => 'نسيت كلمة السر',
                'titles' => [
                    'main'=>'استعادة حسابك',
                ]
            ],
 'profile' => [
                'name' => 'الملف الشخصي',
                'titles' => [
                    'main' => 'مرحباً بك في ملفك الشخصي',
                ],
            ],

'change_password' => [
                'name' => 'تغيير كلمة المرور',
                'titles' => [
                    'main' => 'غير كلمة المرور الخاصة بك',
                ],
            ],
'change_email' => [
                'name' => 'تغيير البريد الإلكتروني',
                'titles' => [
                    'main' => 'غير بريدك الإلكتروني',
                ],
            ],
"user_space" => [
    'name' => "مساحة المستخدم",
    "titles" => [
        "main" => "مرحبًا بك في مساحتك"
    ]
],
"medical_file" => [
    'name' => "الملف الطبي",
    "titles" => [
        "main" => 'إدارة الملف الطبي لـ :name رقم : :code'
    ]
],
"medical_files" => [
    'name' => "الملفات الطبية",
    "titles" => [
        "main" => "السجلات الطبية - سجل الاستشارات"
    ]
],
"patient_visits" => [
    'name' => "زيارات المرضى",
    "titles" => [
        "main" => ":name :code - سجل الزيارات الطبية"
    ]
],
'admin_space' => [
                'name' => 'مساحة المسؤول',
                'titles' => [
                    'main' => 'أهلاً بك في لوحة تحكم المسؤول',
                ],
            ],
'super_admin_space' => [
                'name' => 'مساحة المسؤول الأعلى',
                'titles' => [
                    'main' => 'أهلاً بك في لوحة تحكم المسؤول الأعلى',
                ],
            ],
"doctor_space" => [
    'name' => "مساحة الطبيب",
    "titles" => [
        "main" => "مرحبا بك دكتور"
    ]
],
"wilayates" => [
    'name' => "الولايات",
    "titles" => [
        "main" => "إدارة الولايات"
    ]
],
"wilaya" => [
    'name' => "الدوائر",
    "titles" => [
        "main" => "إدارة الدوائر (رمز الولاية: :code)"
    ]
],
"occupation_fields" => [
    'name' => "المجالات المهنية",
    "titles" => [
        "main" => "إدارة المجالات المهنية"
    ]
],
"establishment_admin_space" => [
    'name' => "إدارة المؤسسة",
    "titles" => [
        "main" => "لوحة تحكم مسؤول المؤسسة"
    ]
],

"appointments_location_admin_space" => [
    'name' => "إدارة مواقع المواعيد",
    "titles" => [
        "main" => "لوحة تحكم مدير مواقع المواعيد"
    ]
],
"service_admin_space" => [
    'name' => "إدارة الخدمات",
    "titles" => [
        "main" => "لوحة تحكم مدير الخدمات"
    ]
],
"manage_appointments_location_admins" => [
    'name' => "إدارة مواقع المواعيد",
    "titles" => [
        "main" => "لوحة تحكم مواقع المواعيد"
    ]
],
'manage_landing'=>[
    "name"=>"إدارة صفحة الهبوط",
    "titles"=>[
        "main"=>"إدارة معلومات صفحة الهبوط"
    ],
],
"general_infos"=>[
    "name"=>"إدارة المعلومات العامة",
    "titles"=>[
        "main"=>"إدارة المعلومات العامة للتطبيق"
    ],
],
'manage_about_us' => [
    'name' => "إدارة صفحة من نحن",
    'titles' => [
        'main' => "إدارة صفحة من نحن"
    ],
],
'manage_our_qualities' => [
    'name' => "إدارة صفحة مميزاتنا",
    'titles' => [
        'main' => "إدارة صفحة مميزاتنا"
    ],
],
'manage_socials' => [
    'name' => 'صفحة إدارة الشبكات الاجتماعية',
    'titles' => [
        'main' => 'إدارة شبكاتك الاجتماعية',
    ],
],
'messages' => [
    'name' => 'إدارة الرسائل',
    'titles' => [
        'main' => 'إدارة رسائل الزوار', // More natural Arabic phrasing
    ],
],
'banks' => [
    'name' => 'إدارة البنوك',
    'titles' => [
        'main' => 'إدارة البنوك',
    ],
],

'services' => [
    'name' => 'إدارة الخدمات',
    'titles' => [
        'main' => 'إدارة الخدمات',
    ],
],


'articles' => [
    'name' => 'إدارة المقالات',
    'titles' => [
        'main' => 'إدارة المقالات',
    ],
],

'menus' => [
    'name' => 'إدارة القوائم',
    'titles' => [
        'main' => 'إدارة القوائم',
    ],
],
'menu' => [
    'name' => 'إدارة القائمة',
    'titles' => [
        'main' => 'إدارة الروابط الخارجية للقائمة :title',
    ],
],
'sliders' => [
    'name' => 'إدارة السلايدر',
    'titles' => [
        'main' => 'إدارة السلايدر',
    ],
],
'slider' => [
    'name' => 'إدارة الشرائح',
    'titles' => [
        'main' => 'إدارة الشرائح لـ :name',
    ],
],
'trends' => [
    'name' => 'إدارة الاتجاهات',
    'titles' => [
        'main' => 'إدارة الاتجاهات',
    ],
],

'establishment' => [
    'name' => 'تفاصيل :acronym',
    'titles' => [
        'main' => 'إدارة تفاصيل :acronym',
    ],
],


];
