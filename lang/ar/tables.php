<?php
return [
    "common" => [
        "excel-file-type-err" => "يجب أن يكون الملف بتنسيق إكسل (XLSX ، XLS ، CSV)",
        'actions' => 'إجراءات',
        'perPage' => 'لكل صفحة',
    ],
    'our_qualities' => [
        'info' => 'قائمة الجودات لدينا',
        'not_found' => 'لم يتم العثور على أي جودات في الوقت الحالي',
        'created_at' => 'تاريخ الإضافة',
        'name' => 'الاسم',
        'status' => 'الحالة',
        'errors' => [
            'active_limit' => 'يمكن تفعيل 4 جودات فقط لعرضها لزوار الموقع',
        ],
    ],
    'messages' => [
        'info' => 'رسائل الزوار',
        'not_found' => 'لم يتم العثور على أي رسائل للزوار في الوقت الحالي', // More natural
        'name' => 'الاسم',
        'email' => 'البريد الإلكتروني',
        'created_at' => 'تاريخ الاستلام', // More natural
    ],
'users' => [
    "info" => [
        'default' => 'سجل الموظفين',
        "establishment" => "دليل الموظفين - المنشأة: :acronym",
        "service" => "دليل الموظفين - المصلحة: :acronym"
    ],
    "empty" => [
        'default' => "لا توجد سجلات موظفين",
        "establishment" => "لا يوجد موظفون معينون لهذه المنشأة",
        "service" => "لا يوجد موظفون معينون لهذه المصلحة"
    ],
    'establishment' => "المنشأة المعينة",
    'service' => "المصلحة المعينة",
    "full_name" => "الاسم الكامل",
    "full_name_fr" => "الاسم (فرنسي)",
    "full_name_ar" => "الاسم (عربي)",
    "employee_number" => "رقم الموظف",
    "social_number" => "رقم الضمان الاجتماعي",
    "email" => "البريد الإلكتروني الرسمي",
    "registration_date" => "تاريخ التسجيل",
    "phone" => "رقم الاتصال",
    "card_number" => "رقم الهوية الوطنية",
    "birth_date" => "تاريخ الميلاد",
    "birth_place_fr" => "مكان الميلاد (فرنسي)",
    "birth_place_ar" => "مكان الميلاد (عربي)",
    "birth_place_en" => "مكان الميلاد (إنجليزي)",
    "excel" => [
        "upload" => [
            "success" => "تم استيراد سجلات الموظفين بنجاح"
        ]
    ]
],
'wilayates' => [
    "info" => "دليل الولايات",
    "not_found" => "لا توجد ولايات متاحة حالياً",
    "code" => "رمز الولاية",
    "designation" => "اسم الولاية",
    "designation_fr" => "الاسم الفرنسي",
    "designation_ar" => "الاسم العربي",
    "designation_en" => "الاسم الإنجليزي",
    "registration_date" => "تاريخ التسجيل",
    "excel" => [
        "upload" => [
            "success" => "تم استيراد بيانات الولايات بنجاح"
        ]
    ]
],
'dairates' => [
    "info" => "دوائر الولاية (الرمز: :code)",
    "not_found" => "لا توجد دوائر متاحة حالياً",
    "code" => "رمز الدائرة",
    "designation" => "اسم الدائرة",
    "designation_fr" => "الاسم الفرنسي",
    "designation_ar" => "الاسم العربي",
    "designation_en" => "الاسم الإنجليزي",
    "registration_date" => "تاريخ التسجيل",
    "excel" => [
        "upload" => [
            "success" => "تم استيراد بيانات الدوائر بنجاح"
        ]
    ]
],
'communes' => [
    "info" => "بلديات الدائرة (الرمز: :code)",
    "not_found" => "لا توجد بلديات متاحة حالياً",
    "code" => "رمز البلدية",
    "designation" => "اسم البلدية",
    "designation_fr" => "الاسم الفرنسي",
    "designation_ar" => "الاسم العربي",
    "designation_en" => "الاسم الإنجليزي",
    "registration_date" => "تاريخ التسجيل",
    "excel" => [
        "upload" => [
            "success" => "تم استيراد بيانات البلديات بنجاح"
        ]
    ]
],
'fields' => [
    "info" => "دليل المجالات",
    "not_found" => "لا توجد مجالات متاحة حالياً",
    "acronym" => "الاختصار",
    "designation" => "التسمية الأساسية",
    "designation_fr" => "التسمية الفرنسية",
    "designation_ar" => "التسمية العربية",
    "designation_en" => "التسمية الإنجليزية",
    "registration_date" => "تاريخ التسجيل",
    "excel" => [
        "upload" => [
            "success" => "تم استيراد المجالات بنجاح"
        ]
    ]
],

'field_grades' => [
    "info" => "مستويات الدرجات للمجال: :acronym",
    "not_found" => "لا توجد مستويات درجات متاحة حالياً",
    "acronym" => "رمز الدرجة",
    "designation" => "مسمى الدرجة",
    "designation_fr" => "المسمى الفرنسي",
    "designation_ar" => "المسمى العربي",
    "designation_en" => "المسمى الإنجليزي",
    "registration_date" => "تاريخ التسجيل",
    "excel" => [
        "upload" => [
            "success" => "تم استيراد مستويات الدرجات بنجاح"
        ]
    ]
],
'field_specialties' => [
    "info" => "التخصصات المهنية: :acronym",
    "not_found" => "لا توجد تخصصات متاحة حالياً",
    "acronym" => "رمز التخصص",
    "designation" => "مسمى التخصص",
    "designation_fr" => "المسمى الفرنسي",
    "designation_ar" => "المسمى العربي",
    "designation_en" => "المسمى الإنجليزي",
    "registration_date" => "تاريخ التسجيل",
    "excel" => [
        "upload" => [
            "success" => "تم استيراد التخصصات بنجاح"
        ]
    ]
],
'occupations' => [
    'info' => 'قائمة المهن',
    'info_custom' => 'قائمة مهن :name',
    'not_found' => 'لا توجد مهن في الوقت الحالي',
    'is_active' => 'الحالة',
    'entitled' => 'المسمى',
    'field' => 'المجال',
    'experience' => 'الخبرة',
    'specialty' => 'التخصص',
    'grade' => 'الرتبة',
    'created_at' => 'أضيف في',
],
'banking_information' => [
    'info' => 'قائمة المعلومات المصرفية',
    'info_custom' => 'المعلومات المصرفية لـ :name',
    'not_found' => 'لا توجد معلومات مصرفية في الوقت الحالي',
    'bank_acronym' => 'البنك',
    'agency' => 'الوكالة',
    'agency_code' => 'رمز الوكالة',
    'account_number' => 'رقم الحساب',
    'is_active' => 'الحالة',
    'created_at' => 'أضيف في',
],
'banks' => [
    "info" => "دليل البنوك",
    "not_found" => "لا توجد بنوك متاحة حالياً",
    'code' => "رمز البنك",
    'acronym' => "اختصار البنك",
    "designation" => "اسم البنك",
    "designation_fr" => "الاسم الفرنسي",
    "designation_ar" => "الاسم العربي",
    "designation_en" => "الاسم الإنجليزي",
    "created_at" => "تاريخ التسجيل",
],
'menus' => [
    "info" => "قائمة القوائم",
    "not_found" => "لا توجد قوائم حالياً",
    "title" => "العنوان",
    "state" => "الحالة",
    "type" => "النوع",
    "created_at" => "أضيف في",
],
'external_links' => [
    "info" => "قائمة الروابط الخارجية",
    "not_found" => "لا توجد روابط خارجية في الوقت الحالي",
    "name" => "الاسم",
    "url" => "الرابط",
    "created_at" => "تاريخ الإضافة",
],
'articles' => [
    "info" => "قائمة المقالات",
    "not_found" => "لا توجد مقالات حالياً",
    "created_at" => "تاريخ الإضافة",
    'author' => "الكاتب",
    'title' => "العنوان",
    "articleable_type" => "منشور من أجل",
    "articleable_id" => "منشور في",
    "location" => "الموقع",
    "state" => "الحالة",
],
    'sliders' => [
        "info" => "قائمة العروض",
        "not_found" => "لا توجد عروض حتى الآن",
        "created_at" => "تمت الإضافة في",
        "creator" => "المنشئ",
        "name" => "الاسم",
        "sliderable_type" => "نُشر من أجل",
        "sliderable_id" => "نُشر في",
        "location" => "الموقع",
        "state" => "الحالة",
    ],
'establishments' => [
    "info" => "دليل المنشآت",
    "not_found" => "لا توجد منشآت مسجلة حالياً",
    "created_at" => "تاريخ التسجيل",
    "acronym" => "رمز المنشأة",
    "name" => "الاسم الرسمي",
    "name_fr" => "الاسم الفرنسي",
    "name_ar" => "الاسم العربي",
    "name_en" => "الاسم الإنجليزي",
    "email" => "البريد الإلكتروني الرسمي",
    "address" => "العنوان الكامل",
    "description" => "الوصف",
    "tel" => "الهاتف الرئيسي",
    "fax" => "فاكس",
    'daira' => "الدائرة الإدارية",
    'longitude' => "خط الطول",
    'latitude' => "خط العرض",
    'capacity' => "السعة القصوى",
    "excel" => [
        "upload" => [
            "success" => "تم استيراد المنشآت بنجاح"
        ]
    ]
],

'services' => [
    "info" => "قائمة مصلحات المؤسسة:",
    "not_found" => "لا توجد مصلحات مسجلة حالياً",
    "created_at" => "تاريخ التسجيل",
    "name" => "اسم المصلحة",
    "name_fr" => "اسم المصلحة (الفرنسية)",
    "name_en" => "اسم المصلحة (الإنجليزية)",
    "name_ar" => "اسم المصلحة (العربية)",
    "tel" => "الهاتف الرئيسي",
    "fax" => "فاكس",
    "head_service" => "رئيس المصلحة",
    "establishment" => "المؤسسة الأم",
    "type" => "نوع المصلحة",
    "specialty" => "التخصص الطبي",
    "excel" => [
        "upload" => [
            "success" => "تم استيراد المصلحات بنجاح"
        ]
    ]
],

'coordinators' => [
    "name" => "الاسم",
    "employee_number" => "رقم الموظف",
    "email" => "البريد الإلكتروني الرسمي",
    "registration_date" => "تاريخ التسجيل",
    "phone" => "رقم الهاتف",
],
"appointments_location_admins" => [
    "name" => "الاسم",
    "employee_number" => "رقم الموظف",
    "email" => "البريد الإلكتروني الرسمي",
    "registration_date" => "تاريخ التسجيل",
    "phone" => "رقم الهاتف",
],
"available_appointments" => [
    "info" => [
        "follow-ups" => "مواعيد المتابعة للمريض: :code",
        "initials" => "المواعيد المتاحة - يرجى اختيار التاريخ المفضل",
    ],
    "not_found" => "لا توجد مواعيد متاحة حالياً. يرجى التحقق من بيانات النموذج أو المحاولة لاحقاً",
    "date_at" => "تاريخ الموعد",
    "daira" => "الدائرة",
    "doctor" => "الطبيب المعين",
    "appointments_location" => "موقع الموعد",
],
"confirmed_appointments" => [
    "info" => "المواعيد المؤكدة",
    "not_found" => "لا توجد مواعيد متاحة حالياً. يرجى التحقق من عوامل التصفية أو المحاولة لاحقاً",
    "queue_number" => "رقم قائمة الانتظار",
    "patient" => "اسم المريض",
    "patient_code" => "رمز المريض",
    "patient_birth_date" => "تاريخ الميلاد",
    "patient_tel" => "الهاتف",
    "year" => "السنة",
    "month" => "الشهر",
    "specialty" => "التخصص",
    "doctor" => "الطبيب",
    "doctor_name" => "الطبيب",
    'daira' => "الدائرة",
    "location" => "موقع الموعد",
    "schedule_day" => "تاريخ الموعد",
    "date" => "تاريخ الموعد",
    "type" => "النوع",
    "referral_letter" => "خطاب التحويل"
],
'medical_files' => [
    "info" => "الملفات الطبية لأقاربي",
    "not_found" => "لا توجد ملفات طبية متاحة بعد",
    "code" => "الرمز",
    'name' => "الاسم",
    'year' => "السنة",
    "last_name_fr" => "الاسم الأخير (فرنسية)",
    "last_name_ar" => "الاسم الأخير (عربية)",
    "first_name_fr" => "الاسم الأول (فرنسية)",
    "first_name_ar" => "الاسم الأول (عربية)",
    "insurance_number" => "رقم التأمين",
    'gender' => "الجنس",
    "birth_date" => "تاريخ الولادة",
    "tel" => "رقم الهاتف",
    'created_at' => "تاريخ إنشاء السجل"
],
'ratings' => [
    "info" => "تقييمات المرضى للدكتور :doctor",
    "not_found" => "لا توجد تقييمات للمرضى متاحة بعد",
    'doctor' => "الطبيب",
    'user_id' => "المريض",
    'rating' => "درجة رضا المريض (من 1 إلى 5)",
    'created_at' => "تاريخ التقييم"
],
'schedules' => [
    "info" => "قوائم جداول الخدمات",
    "not_found" => "لا توجد جداول",
    "year" => "السنة",
    "month" => "الشهر",
    "name" => "التسمية",
    "name_fr" => "التسمية (فرنسية)",
    "name_en" => "التسمية (إنجليزية)",
    "name_ar" => "التسمية (عربية)",
    "state" => "حالة النشر",
     "created_at"=>"تاريخ الإنشاء",
    "service" => "الخدمة الطبية المصنفة",
    "created_by" => "تم الإنشاء بواسطة"
],
'schedule_days' => [
    "info" =>'  "قوائم مواعيد الجدول ":name"',
    "not_found" => "لا توجد مواعيد في الوقت الحالي",
    'doctor' => "الطبيب",
    "specialty" => "التخصص",
    'day_at' => "تاريخ الموعد",
    'available_number' => "المواعيد المتاحة",
    'confirmed_number' => "المواعيد المؤكدة",
    'state' => "توفر الجدول",
    'appointment_location' => "موقع المواعيد"
],
'visits' => [
    "info" => "سجلات زيارة المرضى",
    "not_found" => "لا توجد سجلات زيارات",
    'appointment' => "رقم الموعد",
    "code" => "رقم المريض",
    'patient' => "اسم المريض",
    'doctor' => "الطبيب المعالج",
    "date" => "تاريخ الاستشارة"
],

'images' => [
    "info" => "قائمة ملفات الصور",
    "not_found" => "لم يتم العثور على ملفات صور",
    'display_name' => "اسم العرض",
    "use_case" => "حالة الاستخدام",
    'created_at' => "تم الإضافة في",
    'preview' => "معاينة",
],
'files' => [
    "info" => "قائمة ملفات PDF",
    "not_found" => "لم يتم العثور على ملفات PDF",
    'display_name' => "اسم العرض",
    "use_case" => "حالة الاستخدام",
    'created_at' => "تم الإضافة في",
    'preview' => "معاينة",
    "download" => "تحميل الملف"
],
];
