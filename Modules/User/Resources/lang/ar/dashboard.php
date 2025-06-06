<?php

return [
    'item_not_found' => "عذراً، هذا العرض هو غير مدرج تحت عروض شركتكم",
    'admins'            => [
        'create'    => [
            'form'  => [
                'confirm_password'  => 'تاكيد كلمة المرور',
                'email'             => 'البريد الالكتروني',
                'general'           => 'بيانات عامة',
                'image'             => 'الصورة الشخصية',
                'info'              => 'البيانات',
                'mobile'            => 'الهاتف',
                'name'              => 'الاسم',
                'password'          => 'كلمة المرور',
                'roles'             => 'الادوار',
                'status'            => 'الحالة',
                '2fa_authentication'    => ' المصادقة الثنائية',
                '2fa_authentication_p'  => 'يرجى مسح هذا الرمز ضوئيًا من خلال Google Authenticator أو تطبيق Duo Mobile',
            ],
            'title' => 'اضافة المدراء',
        ],
        'datatable' => [
            'created_at'    => 'تاريخ الآنشاء',
            'date_range'    => 'البحث بالتواريخ',
            'email'         => 'البريد الالكتروني',
            'image'         => 'الصورة الشخصية',
            'mobile'        => 'الهاتف',
            'name'          => 'الاسم',
            'options'       => 'الخيارات',
        ],
        'index'     => [
            'title' => 'المدراء',
        ],
        'update'    => [
            'form'  => [
                'confirm_password'  => 'تآكيد كلمة المرور',
                'email'             => 'البريد الالكتروني',
                'general'           => 'بيانات عامة',
                'image'             => 'الصورة الشخصية',
                'mobile'            => 'الهاتف',
                'name'              => 'الاسم',
                'password'          => 'تغير كلمة المرور',
                'roles'             => 'الادوار',
            ],
            'title' => 'تعديل المدراء',
        ],
        'validation'=> [
            'email'     => [
                'required'  => 'من فضلك ادخل البريد الالكتروني',
                'unique'    => 'هذا البريد تم ادخالة من قبل',
            ],
            'mobile'    => [
                'digits_between'    => 'من فضلك ادخل ٨ ارقام فقط داخل رقم الهاتف',
                'numeric'           => 'يجب ان يتكون رقم الهاتف من ارقام فقط بالانجليزية',
                'required'          => 'من فضلك ادخل رقم الهاتف',
                'unique'            => 'رقم الهاتف تم ادخالة من قبل',
            ],
            'name'      => [
                'required'  => 'من فضلك ادخل الاسم الشخصي',
            ],
            'password'  => [
                'min'       => 'يجب ان يتكون كلمة المرور من كلمة اكبر من ٦ مدخلات : ارقام او احرف',
                'required'  => 'من فضلك ادخل كلمة المرور',
                'same'      => 'كلمة المرور غير متطابقة مع التآكيد',
            ],
            'roles'     => [
                'required'  => 'من فضلك اختر ادوار المدير',
            ],
        ],
    ],
    'sellers'            => [
        'create'    => [
            'form'  => [
                'confirm_password'  => 'تاكيد كلمة المرور',
                'email'             => 'البريد الالكتروني',
                'general'           => 'بيانات عامة',
                'image'             => 'الصورة الشخصية',
                'info'              => 'البيانات',
                'mobile'            => 'الهاتف',
                'name'              => 'الاسم',
                'password'          => 'كلمة المرور',
                'roles'             => 'الادوار',
            ],
            'title' => 'اضافة البائعين',
        ],
        'datatable' => [
            'created_at'    => 'تاريخ الآنشاء',
            'date_range'    => 'البحث بالتواريخ',
            'email'         => 'البريد الالكتروني',
            'image'         => 'الصورة الشخصية',
            'mobile'        => 'الهاتف',
            'name'          => 'الاسم',
            'options'       => 'الخيارات',
        ],
        'index'     => [
            'title' => 'البائعين',
        ],
        'update'    => [
            'form'  => [
                'confirm_password'  => 'تآكيد كلمة المرور',
                'email'             => 'البريد الالكتروني',
                'general'           => 'بيانات عامة',
                'image'             => 'الصورة الشخصية',
                'mobile'            => 'الهاتف',
                'name'              => 'الاسم',
                'password'          => 'تغير كلمة المرور',
                'roles'             => 'الادوار',
            ],
            'title' => 'تعديل البائعين',
        ],
        'validation'=> [
            'email'     => [
                'required'  => 'من فضلك ادخل البريد الالكتروني',
                'unique'    => 'هذا البريد تم ادخالة من قبل',
            ],
            'mobile'    => [
                'digits_between'    => 'من فضلك ادخل ٨ ارقام فقط داخل رقم الهاتف',
                'numeric'           => 'يجب ان يتكون رقم الهاتف من ارقام فقط بالانجليزية',
                'required'          => 'من فضلك ادخل رقم الهاتف',
                'unique'            => 'رقم الهاتف تم ادخالة من قبل',
            ],
            'name'      => [
                'required'  => 'من فضلك ادخل الاسم الشخصي',
            ],
            'password'  => [
                'min'       => 'يجب ان يتكون كلمة المرور من كلمة اكبر من ٦ مدخلات : ارقام او احرف',
                'required'  => 'من فضلك ادخل كلمة المرور',
                'same'      => 'كلمة المرور غير متطابقة مع التآكيد',
            ],
            'roles'     => [
                'required'  => 'من فضلك اختر ادوار البائع',
            ],
        ],
    ],
    'employees'            => [
        'create'    => [
            'form'  => [
                'confirm_password'  => 'تاكيد كلمة المرور',
                'email'             => 'البريد الالكتروني',
                'general'           => 'بيانات عامة',
                'image'             => 'الصورة الشخصية',
                'info'              => 'البيانات',
                'mobile'            => 'الهاتف',
                'name'              => 'الاسم',
                'password'          => 'كلمة المرور',
                'roles'             => 'الادوار',
            ],
            'title' => 'اضافة الموظفين',
        ],
        'datatable' => [
            'created_at'    => 'تاريخ الآنشاء',
            'date_range'    => 'البحث بالتواريخ',
            'email'         => 'البريد الالكتروني',
            'image'         => 'الصورة الشخصية',
            'mobile'        => 'الهاتف',
            'name'          => 'الاسم',
            'options'       => 'الخيارات',
        ],
        'index'     => [
            'title' => 'الموظفين',
        ],
        'update'    => [
            'form'  => [
                'confirm_password'  => 'تآكيد كلمة المرور',
                'email'             => 'البريد الالكتروني',
                'general'           => 'بيانات عامة',
                'image'             => 'الصورة الشخصية',
                'mobile'            => 'الهاتف',
                'name'              => 'الاسم',
                'password'          => 'تغير كلمة المرور',
                'roles'             => 'الادوار',
            ],
            'title' => 'تعديل الموظفين',
        ],
        'validation'=> [
            'email'     => [
                'required'  => 'من فضلك ادخل البريد الالكتروني',
                'unique'    => 'هذا البريد تم ادخالة من قبل',
            ],
            'mobile'    => [
                'digits_between'    => 'من فضلك ادخل ٨ ارقام فقط داخل رقم الهاتف',
                'numeric'           => 'يجب ان يتكون رقم الهاتف من ارقام فقط بالانجليزية',
                'required'          => 'من فضلك ادخل رقم الهاتف',
                'unique'            => 'رقم الهاتف تم ادخالة من قبل',
            ],
            'name'      => [
                'required'  => 'من فضلك ادخل الاسم الشخصي',
            ],
            'password'  => [
                'min'       => 'يجب ان يتكون كلمة المرور من كلمة اكبر من ٦ مدخلات : ارقام او احرف',
                'required'  => 'من فضلك ادخل كلمة المرور',
                'same'      => 'كلمة المرور غير متطابقة مع التآكيد',
            ],
            'roles'     => [
                'required'  => 'من فضلك اختر ادوار الموظف',
            ],
        ],
    ],
    'medical_profiles'  => [
        'datatable' => [
            'created_at'    => 'تاريخ الآنشاء',
            'date_range'    => 'البحث بالتواريخ',
            'email'         => 'البريد الالكتروني',
            'image'         => 'الصورة الشخصية',
            'mobile'        => 'الهاتف',
            'name'          => 'الاسم',
            'options'       => 'الخيارات',
            'prfoile'       => 'المراجعة',
            'profile'       => 'المراجعة',
        ],
        'form'      => [
            'is_reviewed'   => 'تم المراجعة',
        ],
        'index'     => [
            'title' => 'الملفات الطبية',
        ],
        'update'    => [
            'form'  => [
                'confirm_password'  => 'تآكيد كلمة المرور',
                'email'             => 'البريد الالكتروني',
                'general'           => 'بيانات عامة',
                'image'             => 'الصورة الشخصية',
                'medical_profile'   => 'الملف الطبي',
                'mobile'            => 'الهاتف',
                'name'              => 'الاسم',
                'password'          => 'تغير كلمة المرور',
            ],
            'title' => 'تعديل الملف الطبي',
        ],
        'validation'=> [
            'email'     => [
                'required'  => 'من فضلك ادخل البريد الالكتروني',
                'unique'    => 'هذا البريد تم ادخالة من قبل',
            ],
            'mobile'    => [
                'digits_between'    => 'من فضلك ادخل ٨ ارقام فقط داخل رقم الهاتف',
                'numeric'           => 'يجب ان يتكون رقم الهاتف من ارقام فقط بالانجليزية',
                'required'          => 'من فضلك ادخل رقم الهاتف',
                'unique'            => 'رقم الهاتف تم ادخالة من قبل',
            ],
            'name'      => [
                'required'  => 'من فضلك ادخل الاسم الشخصي',
            ],
            'password'  => [
                'min'       => 'يجب ان يتكون كلمة المرور من كلمة اكبر من ٦ مدخلات : ارقام او احرف',
                'required'  => 'من فضلك ادخل كلمة المرور',
                'same'      => 'كلمة المرور غير متطابقة مع التآكيد',
            ],
        ],
    ],
    'users'             => [
        'create'    => [
            'form'  => [
                'confirm_password'  => 'تاكيد كلمة المرور',
                'email'             => 'البريد الالكتروني',
                'general'           => 'بيانات عامة',
                'image'             => 'الصورة الشخصية',
                'info'              => 'البيانات',
                'mobile'            => 'الهاتف',
                'name'              => 'الاسم',
                'password'          => 'كلمة المرور',
                'expired_at'        => 'تنتهي في',
                'expired'           => 'منتهي',
                'code'              => 'الكود',
                'offer'             => ':offer',

            ],
            'title' => 'اضافة الاعضاء',
        ],
        'datatable' => [
            'created_at'    => 'تاريخ الآنشاء',
            'date_range'    => 'البحث بالتواريخ',
            'email'         => 'البريد الالكتروني',
            'image'         => 'الصورة الشخصية',
            'mobile'        => 'الهاتف',
            'name'          => 'الاسم',
            'options'       => 'الخيارات',
            'clients'       => 'العميل',
        ],
        'index'     => [
            'title' => 'الاعضاء',
        ],
        'update'    => [
            'form'  => [
                'confirm_password'  => 'تآكيد كلمة المرور',
                'email'             => 'البريد الالكتروني',
                'general'           => 'بيانات عامة',
                'image'             => 'الصورة الشخصية',
                'mobile'            => 'الهاتف',
                'name'              => 'الاسم',
                'password'          => 'تغير كلمة المرور',
                'wallets'           => 'المحفظة الالكترونية',
                'wallets_transactions'   => 'عمليات الدفع بالمحفظة الالكترونية',
                'country'           => 'الدولة',
                'balance'           => 'الرصيد المتوفر',
                'out'               => 'دفع طلب',
                'in'                => 'شحن رصيد المحفظة',
                'add_balance'       => 'اضافة رصيد',
            ],
            'title' => 'تعديل العضو',
        ],
        'validation'=> [
            'email'     => [
                'required'  => 'من فضلك ادخل البريد الالكتروني',
                'unique'    => 'هذا البريد تم ادخالة من قبل',
            ],
            'mobile'    => [
                'digits_between'    => 'من فضلك ادخل ٨ ارقام فقط داخل رقم الهاتف',
                'numeric'           => 'يجب ان يتكون رقم الهاتف من ارقام فقط بالانجليزية',
                'required'          => 'من فضلك ادخل رقم الهاتف',
                'unique'            => 'رقم الهاتف تم ادخالة من قبل',
            ],
            'name'      => [
                'required'  => 'من فضلك ادخل الاسم الشخصي',
            ],
            'password'  => [
                'min'       => 'يجب ان يتكون كلمة المرور من كلمة اكبر من ٦ مدخلات : ارقام او احرف',
                'required'  => 'من فضلك ادخل كلمة المرور',
                'same'      => 'كلمة المرور غير متطابقة مع التآكيد',
            ],
        ],
    ],
    'redeemed_before'   => 'تم استرداد العرض من قبل',
    'redeemed' =>  'تم استرداد العرض بنجاح',
    'redeem' => 'استرداد العرض',
];
