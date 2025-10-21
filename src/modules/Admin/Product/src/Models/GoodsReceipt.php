<?php

namespace Modules\Admin\Product\src\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Product\factories\GoodsReceiptFactory;
use Modules\Admin\Provide\src\Models\Provide;
use Modules\Admin\stock\src\Models\Stock;
use Modules\Admin\Employee\src\Models\Employee;
class GoodsReceipt extends Model
{
    use HasFactory;

    protected $table = 'goods_receipt';

    protected $fillable =[
        'code', 'count', 'date_receive', 'discount', 'subtotal', 'total','note', 'note_cancel',
        'other_cost', 'products', 'status', 'employee_id', 'provide_id', 'stock_id'
    ];

    public function provide(){
        return $this->belongsTo(
            Provide::class,
            'provide_id',
            'id'
        );
    }

    public function stock() {
        return $this->belongsTo(
            Stock::class,
            'stock_id',
            'id'
        );
    }

    public function employee() {
        return $this->belongsTo(
            Employee::class,
            'employee_id',
            'id'
        );
    }
    protected static function newFactory()
    {
        return GoodsReceiptFactory::new();
    }
}
