<?php

return [

    // ✅ رسائل التحقق الأساسية
    'required' => 'حقل :attribute مطلوب.',
    'unique' => ':attribute مُستخدم من قبل.',
    'email' => 'يجب أن يكون :attribute بريدًا إلكترونيًا صالحًا.',
    'in' => 'يجب أن يكون :attribute أحد القيم التالية: :values.',
    'date' => 'يجب أن يكون :attribute تاريخًا صالحًا.',
    'integer' => 'يجب أن يكون :attribute عددًا صحيحًا.',
    'string' => 'يجب أن يكون :attribute نصًا.',
    'exists' => ':attribute المحدد غير صالح.',
    'max' => [
        'string' => 'يجب ألا يتجاوز :attribute :max حرفًا.',
        'numeric' => 'يجب ألا تكون قيمة :attribute أكبر من :max.',
    ],
    'validation_error' => 'خطأ في التحقق من الصحة',

    // ✅ أسماء الحقول المخصصة
    'attributes' => [
        'first_name' => 'الاسم باللاتينية',
        'last_name' => 'اللقب باللاتينية',
        'first_name_ar' => 'الاسم',
        'last_name_ar' => 'اللقب',
        'email' => 'البريد الإلكتروني',
        'cin' => 'رقم بطاقة التعريف الوطنية',
        'passport' => 'رقم جواز السفر',
        'birth_date' => 'تاريخ الميلاد',
        'country' => 'البلد',
        'gender' => 'الجنس',
        'address' => 'العنوان',
        'phone' => 'رقم الهاتف',
        'previous_degree' => 'الشهادة السابقة',
        'graduation_year' => 'سنة التخرج',
        'how_did_you_hear' => 'كيف سمعت عنا',
        'desired_degree_id' => 'الشهادة المرغوبة',
        'name' => 'الاسم',
        'service' => 'الخدمة',
        'message' => 'الرسالة',
    ],
];
