<?php
return [
    'required' => ':attribute không được phép để trống',
    'email' => ':attribute không hợp lệ',
    'date' => ':attribute phải làm một ngày',
    'integer' => ':attribute phải làm một số',
    'numeric' => ':attribute phải làm một số',
    'min' => [
        'string'  => ':attribute phải có ít nhất :min ký tự.',
        'numeric' => ':attribute phải lớn hơn hoặc bằng :min.',
        'array'   => ':attribute phải có ít nhất :min phần tử.',
        'file'    => ':attribute phải có dung lượng tối thiểu :min KB.',
    ],
    'string' => ':attribute phải làm một chuỗi',
    'file' => ':attribute bắt buộc phải là một file',
    'image' => ':attribute không phải là một file ảnh',
    'max' => [
        'string'  => ':attribute tối đa có :max ký tự.',
        'numeric' => ':attribute phải lớn hơn hoặc bằng :max.',
        'array'   => ':attribute tối đa có :max phần tử.',
        'file'    => ':attribute dung lượng tối đa là :max KB.',
    ],
    'same' => ':attribute không khớp.',
    'password' => [
        'min' => ':attribute phải có ít nhất :min ký tự.',
        'letters' => ':attribute phải chứa ít nhất một chữ cái.',
        'mixed' => ':attribute phải chứa cả chữ hoa và chữ thường.',
        'numbers' => ':attribute phải chứa ít nhất một chữ số.',
        'symbols' => ':attribute phải chứa ít nhất một ký tự đặc biệt.',

    ],
    'confirmed' => ':attribute nhập lại không khớp.',
    'attributes' => [
        'name' => 'Tên người dùng',
        'email' => 'Email người dùng',
        'password' => 'Mật khẩu',
        'password_confirmation' => 'Mật khẩu nhập lại'
    ],
];
