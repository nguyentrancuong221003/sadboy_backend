<?php

namespace Modules\Admin\Employee\seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\Employee\src\Models\Department;
class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = [
            [
                'name' => 'Phòng Nhân sự',
                'code' => 'HR',
                'status' => 'ACT',
                'description' => 'Quản lý nhân sự và tuyển dụng'
            ],
            [
                'name' => 'Phòng Công nghệ Thông tin',
                'code' => 'IT',
                'status' => 'ACT',
                'description' => 'Phát triển và bảo trì hệ thống CNTT'
            ],
            [
                'name' => 'Phòng Marketing',
                'code' => 'MK',
                'status' => 'ACT',
                'description' => 'Thực hiện các hoạt động quảng bá thương hiệu'
            ],
            [
                'name' => 'Phòng Tài chính',
                'code' => 'FN',
                'status' => 'ACT',
                'description' => 'Quản lý tài chính, kế toán'
            ],
            [
                'name' => 'Phòng Kinh doanh',
                'code' => 'KD',
                'status' => 'ACT',
                'description' => 'Phát triển thị trường và khách hàng'
            ],
            [
                'name' => 'Phòng Chăm sóc Khách hàng',
                'code' => 'CSKH',
                'status' => 'ACT',
                'description' => 'Hỗ trợ và duy trì mối quan hệ khách hàng'
            ],
            [
                'name' => 'Phòng Dự án',
                'code' => 'DA',
                'status' => 'ACT',
                'description' => 'Lập kế hoạch và quản lý các dự án'
            ],
            [
                'name' => 'Phòng Kỹ thuật',
                'code' => 'KT',
                'status' => 'ACT',
                'description' => 'Triển khai và hỗ trợ kỹ thuật cho sản phẩm/dịch vụ'
            ],
            [
                'name' => 'Phòng Nghiên cứu & Phát triển',
                'code' => 'NCPT',
                'status' => 'ACT',
                'description' => 'Nghiên cứu sản phẩm mới và cải tiến công nghệ'
            ],
            [
                'name' => 'Phòng Quan hệ Quốc tế',
                'code' => 'QHQT',
                'status' => 'ACT',
                'description' => 'Phát triển hợp tác và liên kết quốc tế'
            ],
            [
                'name' => 'Phòng Kiểm soát Chất lượng',
                'code' => 'QA',
                'status' => 'ACT',
                'description' => 'Đảm bảo chất lượng sản phẩm/dịch vụ'
            ],
            [
                'name' => 'Phòng Hành chính',
                'code' => 'HC',
                'status' => 'ACT',
                'description' => 'Xử lý công việc hành chính, hậu cần'
            ]
        ];

        foreach($departments as $department) {
            Department::create($department);
        }

    }
}
