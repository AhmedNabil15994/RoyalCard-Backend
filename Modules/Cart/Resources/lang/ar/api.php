<?php

return [
    'products'    => [
        'not_found' => 'المنتج غير موجود',
        'request_limit' => "عذرا لا يمكنك طلب أكثر من :limit عنصر",
        'invalid_account_id' => "عذرا الرجاء إدخال معرف الحساب",
        'invalid_server'    => "عذرًا، الخادم غير صالح، يرجى اختيار الخادم الصحيح لمعرف الحساب الذي تم إدخاله",
        'invalid_qty'       => 'عذرا الرجاء ادخال الكمية'
    ],
    'cart'  => [
        'empty_cart'    => "سلة التسوق فارغة",
        'invalid_country_id'    => "الدولة غير موجوده، يرجى تحديد الدولة",
        'invalid_payment'   => "الدفع عبر الإنترنت غير صالح الآن",
        'success_payment'   => 'تم الدفع بنجاح',
        'invalid_order'     => 'الطلب غير صالح، يرجى التحقق مرة أخرى',
        'order_cancelled'   => 'تم إلغاء الطلب بنجاح!!',
        'failed_payment'    => 'فشل الدفع، يرجى المحاولة مرة أخرى',
        'insufficient_wallet_balance'   => 'فشل الدفع، نأسف لعدم توافر رصيد كافي في محفظتك',
        'max_balance_exceed'   => "عذرًا، لا يمكنك إعادة الشحن بأكثر من :limit في :country",
        'low_balance'   => "عذرًا، لا يمكنك إعادة الشحن بأقل من :limit في :country",
        'wallet_balance_exceed'   => "عذرًا، يجب ألا يتجاوز رصيد محفظتك :limit في :country",
    ]
];
