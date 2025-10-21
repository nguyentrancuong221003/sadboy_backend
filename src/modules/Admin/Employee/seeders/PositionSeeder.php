<?php

namespace Modules\Admin\Employee\seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\Employee\src\Models\Position;
class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $positions =  [
            [
                'name' => 'Tổng Giám đốc',
                'code' => 'CEO',
                'status' => 'ACT',
                'description' => 'Lãnh đạo cao nhất trong công ty'
            ],
            [
                'name' => 'Giám đốc Điều hành',
                'code' => 'COO',
                'status' => 'ACT',
                'description' => 'Quản lý hoạt động hàng ngày'
            ],
            [
                'name' => 'Giám đốc Tài chính',
                'code' => 'CFO',
                'status' => 'ACT',
                'description' => 'Quản lý tài chính và chiến lược tài chính'
            ],
            [
                'name' => 'Giám đốc Công nghệ',
                'code' => 'CTO',
                'status' => 'ACT',
                'description' => 'Phụ trách công nghệ, kỹ thuật'
            ],
            [
                'name' => 'Giám đốc Marketing',
                'code' => 'CMO',
                'status' => 'ACT',
                'description' => 'Lập kế hoạch và triển khai chiến lược tiếp thị'
            ],
            [
                'name' => 'Trưởng phòng Nhân sự',
                'code' => 'HRM',
                'status' => 'ACT',
                'description' => 'Quản lý nhân sự và tuyển dụng'
            ],
            [
                'name' => 'Quản lý Dự án',
                'code' => 'PM',
                'status' => 'ACT',
                'description' => 'Lập kế hoạch và quản lý các dự án'
            ],
            [
                'name' => 'Trưởng nhóm',
                'code' => 'TL',
                'status' => 'ACT',
                'description' => 'Quản lý nhóm nhỏ hoặc nhóm kỹ thuật'
            ],
            [
                'name' => 'Lập trình viên',
                'code' => 'DEV',
                'status' => 'ACT',
                'description' => 'Phát triển phần mềm'
            ],
            [
                'name' => 'Kiểm thử phần mềm',
                'code' => 'QA',
                'status' => 'ACT',
                'description' => 'Kiểm tra và đảm bảo chất lượng sản phẩm'
            ],
            [
                'name' => 'Nhân viên Kinh doanh',
                'code' => 'SALE',
                'status' => 'ACT',
                'description' => 'Bán hàng và phát triển khách hàng'
            ],
            [
                'name' => 'Nhân viên Chăm sóc Khách hàng',
                'code' => 'CSKH',
                'status' => 'ACT',
                'description' => 'Hỗ trợ và chăm sóc khách hàng'
            ],
            [
                'name' => 'Thực tập sinh',
                'code' => 'TTS',
                'status' => 'ACT',
                'description' => 'Học việc và hỗ trợ công việc cơ bản'
            ]
        ];

        foreach($positions as $position){
            Position::create($position);
        }

    }
}
