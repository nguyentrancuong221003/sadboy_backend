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
    'file' => ':attribute bắt buộc phải là một file',
    'image' => ':attribute không phải là một file ảnh',
    'max' => [
        'string'  => ':attribute tối đa có :max ký tự.',
        'numeric' => ':attribute phải lớn hơn hoặc bằng :max.',
        'array'   => ':attribute tối đa có :max phần tử.',
        'file'    => ':attribute dung lượng tối đa là :max KB.',
    ],

    'attributes' => [
        'code' => 'Mã nhân viên',
        'money' => 'Tiền',
        'reason' => 'Lý do thu/chi',
        'receiver' => 'Đối tương thu/chi',
        'name' => 'Tên đối tượng thu/chi',
        'type' => 'Loại phiếu',
        'imgs' => 'Ảnh',
        'receiver' => 'Đối tượng',
        'name' => 'Tên đối tượng'
    ],
];

