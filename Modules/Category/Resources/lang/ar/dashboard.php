<?php

return [
    'categories'        => [
        'datatable' => [
            'created_at'    => 'تاريخ الآنشاء',
            'date_range'    => 'البحث بالتواريخ',
            'image'         => 'الصورة',
            'options'       => 'الخيارات',
            'status'        => 'الحالة',
            'title'         => 'العنوان',
            'type'          => 'النوع',
            'parent'        => 'قسم رئيسي',
            'child'         => 'قسم فرعي',
        ],
        'form'      => [
            'image'             => 'الصورة',
            'color'             => 'اللون',
            'main_category'     => 'قسم رئيسي',
            'meta_description'  => 'Meta Description',
            'meta_keywords'     => 'Meta Keywords',
            'status'            => 'الحالة',
            'sort'              => 'الترتيب',
            'restore'            => 'إسترجاع',
            'banner'            => 'بانر الموقع',
            'width_ratio'       => 'نسبة العرض (التطبيق)',
            'height_ratio'       => 'نسبة الطول (التطبيق)',
            'mobile_banner'            => 'بانر الموبايل',
            'tabs'              => [
                'category_level'    => 'مستوى الاقسام',
                'category_banner'   => 'بيانات بانر القسم',
                'general'           => 'بيانات عامة',
                'seo'               => 'SEO',
                'cashback'          => 'الاسترداد النقدي',
            ],
            'title'             => 'عنوان',
            'banner_status'     => 'عرض البانر؟',
            'start_at'          => 'تاريخ بداية عرض البانر',
            'expired_at'        => 'تاريخ نهاية عرض البانر',
            'banner_size'       => 'عرض البانر ( % )',
        ],
        'routes'    => [
            'create'    => 'اضافة الاقسام',
            'index'     => 'الاقسام',
            'update'    => 'تعديل القسم',
        ],
        'validation'=> [
            'category_id'   => [
                'required'  => 'من فضلك اختر مستوى القسم',
            ],
            'image'         => [
                'required'  => 'من فضلك اختر الصورة',
            ],
            'title'         => [
                'required'  => 'من فضلك ادخل العنوان',
                'unique'    => 'هذا العنوان تم ادخالة من قبل',
            ],
        ],
    ],
];
