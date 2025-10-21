<?php
return [
    'required' => ':attribute không được phép để trống',
    'integer' => ':attribute phải làm một số',
    'exists' => ':attribute không tồn tại trong hệ thống',
    'string' => ':attribute phải là một số',
    'min' => [
        'string'  => ':attribute phải có ít nhất :min ký tự.',
        'numeric' => ':attribute phải lớn hơn hoặc bằng :min.',
        'array'   => ':attribute phải có ít nhất :min phần tử.',
        'file'    => ':attribute phải có dung lượng tối thiểu :min KB.',
    ],
    'attributes' => [
        'code' => 'Mã số',
        'count' => 'Số lượng',
        'product_id' => 'Mã sản phẩm',
        'size' => 'Kích thước'
    ],
];
