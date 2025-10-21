<?php

namespace Modules\Admin\Order\seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\Order\src\Models\OrderStatuses;
class OrderStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses= [
            [
                'status' => "Đã giao",
                'note' => "Giao hàng thành công. Người nhận: Nguyễn Trần Cường",
                'location' => 'kho hoàng mai'
            ],
            [
                'status' => "Đang vận chuyển",
                'note' => "Đơn hàng sẽ sớm được giao, vui lòng chú ý điện thoại",
                'location' => 'kho hai bà trưng'
            ],
            [
                'status' => "Đã sắp xếp tài xế",
                'note' => "Tài xế đã nhận đơn và chuẩn bị giao",
                'location' => 'kho lĩnh nam'
            ],
            [
                'status' => "Đơn hàng đến trạm",
                'note' => "Đơn hàng đã đến trạm giao hàng tại Hai Bà Trưng",
                'location' => 'kho vĩnh tuy'
            ],
            [
                'status' => "Đơn hàng đến trạm",
                'note' => "Đơn hàng đã đến trạm giao hàng tại Hai Bà Trưng",
                'location' => 'kho long biên'
            ],
            [
                'status' => "Đã giao",
                'note' => "Giao hàng thành công. Người nhận: Nguyễn Trần Cường",
                'location' => 'kho cầu giấy'
            ],
            [
                'status' => "Đang vận chuyển",
                'note' => "Đơn hàng sẽ sớm được giao, vui lòng chú ý điện thoại",
                'location' => 'kho thanh xuân'
            ],
            [
                'status' => "Đã sắp xếp tài xế",
                'note' => "Tài xế đã nhận đơn và chuẩn bị giao",
                'location' => 'kho đông anh'
            ],
            [
                'status' => "Đơn hàng đến trạm",
                'note' => "Đơn hàng đã đến trạm giao hàng tại Hai Bà Trưng",
                'location' => 'kho nguyễn khoái'
            ],
            [
                'status' => "Đơn hàng đến trạm",
                'note' => "Đơn hàng đã đến trạm giao hàng tại Hai Bà Trưng",
                'location' => 'kho linh đàm'
            ]
        ];
        foreach($statuses as $status) {
            OrderStatuses::factory()->create([
                'order_id' => 1,
                'status' => $status['status'],
                'location' => $status['location'],
                'note' => $status['note']
            ]);
        }
    }
}
