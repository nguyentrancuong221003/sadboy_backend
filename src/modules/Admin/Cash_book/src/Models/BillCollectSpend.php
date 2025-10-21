<?php

namespace Modules\Admin\Cash_book\src\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Cash_book\factories\BillCollectSpendFactory;

class BillCollectSpend extends Model
{
    use HasFactory;

    protected $table = 'bill_collect_spend';

    protected $fillable = [
        'code', 'type', 'reason', 'money', 'imgs', 'object', 'name_object', 'created_by', 'updated_by'
    ];

    protected static function newFactory()
    {
        return BillCollectSpendFactory::new();
    }
}
