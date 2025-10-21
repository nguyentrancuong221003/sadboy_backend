<?php
return [
    'required' => ':attribute không được phép để trống',
    'email' => ':attribute không hợp lệ',
    'date' => ':attribute phải làm một ngày',
    'integer' => ':attribute phải làm một số',
    'numeric' => ':attribute phải làm một số',
    'unique' => ':attribute đã tồn tại',
    'string' => ':attribute phải là một chuỗi',
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
    'exists' => ':attribute không tồn tại trong hệ thống',
    'json' => ':attribute phải có kiểu dữ liệu JSON',
    'array' => ':attribute phải là một danh sách',
    'decimal' => ':attribute dữ liệu không đúng định dạng',
    'attributes' => [
        'code' => 'Mã bình luận',
        'content' => 'Nội dung bình luận',
        'imgs' => 'Ảnh bình luân',
        'star' => 'Số sao',
        'product_id' => 'Sản phẩm'


    ],
];
