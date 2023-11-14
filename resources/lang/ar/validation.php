<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'يجب قبول :attribute.',
    'active_url' => ':attribute ليس عنوان URL صحيح.',
    'after' => ':attribute يجب أن يكون تاريخًا بعد :date.',
    'after_or_equal' => ':attribute يجب أن يكون تاريخًا بعد أو يساوي :date.',
    'alpha' => ':attribute يجب أن يحتوي على أحرف فقط.',
    'alpha_dash' => ':attribute يجب أن يحتوي على أحرف وأرقام وشرطات وشرطات سفلية فقط.',
    'alpha_num' => ':attribute يجب أن يحتوي على أحرف وأرقام فقط.',
    'array' => ':attribute يجب أن يكون مصفوفة.',
    'before' => ':attribute يجب أن يكون تاريخًا قبل :date.',
    'before_or_equal' => ':attribute يجب أن يكون تاريخًا قبل أو يساوي :date.',
    'between' => [
        'numeric' => ':attribute يجب أن يكون بين :min و :max.',
        'file' => ':attribute يجب أن يكون بين :min و :max كيلوبايت.',
        'string' => ':attribute يجب أن يكون بين :min و :max حرفًا.',
        'array' => ':attribute يجب أن يحتوي بين :min و :max عنصرًا.',
    ],
    'boolean' => 'حقل :attribute يجب أن يكون صحيحًا أو خطأ.',
    'confirmed' => 'تأكيد :attribute غير متطابق.',
    'date' => ':attribute ليس تاريخًا صحيحًا.',
    'date_equals' => ':attribute يجب أن يكون تاريخًا يساوي :date.',
    'date_format' => ':attribute لا يتطابق مع الشكل :format.',
    'different' => ':attribute و :other يجب أن يكونا مختلفين.',
    'digits' => ':attribute يجب أن يكون :digits أرقام.',
    'digits_between' => ':attribute يجب أن يكون بين :min و :max أرقام.',
    'dimensions' => ':attribute يحتوي على أبعاد صورة غير صالحة.',
    'distinct' => 'حقل :attribute يحتوي على قيمة مكررة.',
    'email' => ':attribute يجب أن يكون عنوان بريد إلكتروني صحيح.',
    'ends_with' => ':attribute يجب أن ينتهي بأحد القيم التالية: :values.',
    'exists' => ':attribute المحدد غير صالح.',
    'file' => ':attribute يجب أن يكون ملفًا.',
    'filled' => 'حقل :attribute يجب أن يحتوي على قيمة.',
    'gt' => [
        'numeric' => ':attribute يجب أن يكون أكبر من :value.',
        'file' => ':attribute يجب أن يكون أكبر من :value كيلوبايت.',
        'string' => ':attribute يجب أن يكون أكبر من :value حرفًا.',
        'array' => ':attribute يجب أن يحتوي على أكثر من :value عنصر.',
    ],
    'gte' => [
    'numeric' => 'يجب أن يكون :attribute أكبر من أو يساوي :value.',
    'file' => 'يجب أن يكون حجم :attribute أكبر من أو يساوي :value كيلوبايت.',
    'string' => 'يجب أن يكون طول :attribute أكبر من أو يساوي :value حرفًا.',
    'array' => 'يجب أن يحتوي :attribute على :value عنصر أو أكثر.',
],
'image' => 'يجب أن يكون :attribute صورة.',
'in' => 'القيمة المحددة في :attribute غير صالحة.',
'in_array' => 'حقل :attribute غير موجود في :other.',
'integer' => 'يجب أن يكون :attribute عددًا صحيحًا.',
'ip' => 'يجب أن يكون :attribute عنوان IP صالحًا.',
'ipv4' => 'يجب أن يكون :attribute عنوان IPv4 صالحًا.',
'ipv6' => 'يجب أن يكون :attribute عنوان IPv6 صالحًا.',
'json' => 'يجب أن يكون :attribute سلسلة JSON صالحة.',
'lt' => [
    'numeric' => 'يجب أن يكون :attribute أقل من :value.',
    'file' => 'يجب أن يكون حجم :attribute أقل من :value كيلوبايت.',
    'string' => 'يجب أن يكون طول :attribute أقل من :value حرفًا.',
    'array' => 'يجب أن يحتوي :attribute على أقل من :value عنصر.',
],
'max' => [
    'numeric' => 'يجب ألا يتجاوز :attribute القيمة :max.',
    'file' => 'يجب ألا يتجاوز حجم :attribute :max كيلوبايت.',
    'string' => 'يجب ألا يتجاوز طول :attribute :max حرفًا.',
    'array' => 'يجب ألا يحتوي :attribute على أكثر من :max عنصر.',
],
'mimes' => 'يجب أن يكون :attribute ملفًا من النوع: :values.',
'mimetypes' => 'يجب أن يكون :attribute ملفًا من النوع: :values.',
'min' => [
    'numeric' => 'يجب أن يكون :attribute على الأقل :min.',
    'file' => 'يجب أن يكون حجم :attribute على الأقل :min كيلوبايت.',
    'string' => 'يجب أن يكون طول :attribute على الأقل :min حرفًا.',
    'array' => 'يجب أن يحتوي :attribute على الأقل :min عنصر.',
],
    'multiple_of' => 'يجب أن يكون :attribute مضاعفًا للقيمة :value.',
'not_in' => 'القيمة المُحددة لـ :attribute غير صالحة.',
'not_regex' => 'تنسيق :attribute غير صالح.',
'numeric' => 'يجب أن يكون :attribute عبارة عن رقم.',
'password' => 'كلمة المرور غير صحيحة.',
'present' => 'يجب أن يكون حقل :attribute موجودًا.',
'regex' => 'تنسيق :attribute غير صالح.',
'required' => 'حقل :attribute مطلوب.',
'required_if' => 'حقل :attribute مطلوب عندما يكون :other :value.',
'required_unless' => 'حقل :attribute مطلوب ما لم يكن :other في :values.',
'required_with' => 'حقل :attribute مطلوب عندما تكون :values موجودة.',
'required_with_all' => 'حقل :attribute مطلوب عندما تكون كل من :values موجودة.',
'required_without' => 'حقل :attribute مطلوب عندما لا تكون :values موجودة.',
'required_without_all' => 'حقل :attribute مطلوب عندما لا يكون أي من :values موجودًا.',
'prohibited' => 'حقل :attribute محظور.',
'prohibited_if' => 'حقل :attribute محظور عندما يكون :other :value.',
'prohibited_unless' => 'حقل :attribute محظور ما لم يكن :other في :values.',
'same' => 'يجب أن يتطابق :attribute مع :other.',

'size' => [
    'numeric' => 'يجب أن يكون :attribute :size.',
    'file' => 'يجب أن يكون حجم :attribute :size كيلوبايت.',
    'string' => 'يجب أن يكون طول :attribute :size أحرف.',
    'array' => 'يجب أن يحتوي :attribute على :size عنصرًا.',
],
'starts_with' => 'يجب أن يبدأ :attribute بأحد القيم التالية: :values.',
'string' => 'يجب أن يكون :attribute سلسلة نصية.',
'timezone' => 'يجب أن يكون :attribute منطقة زمنية صحيحة.',
'unique' => 'تم اختيار :attribute مسبقًا.',
'uploaded' => 'فشل في تحميل :attribute.',
'url' => 'تنسيق :attribute غير صالح.',
'uuid' => 'يجب أن يكون :attribute UUID صالحًا.',


    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
