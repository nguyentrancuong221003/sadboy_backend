<?php

namespace Modules\Admin\Provide\src\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Provide\factories\ProvideFactory;
use Modules\Admin\Provide\src\Models\ProvideDetails;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Admin\Product\src\Models\GoodsReceipt;
class Provide extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'provides';

    protected $fillable = [
        'code', 'name', 'phone', 'address', 'email',
        'img', 'note', 'status', 'created_by', 'updated_by'
    ];

    public function detail() {
        return $this->hasOne(
            ProvideDetails::class,
            'provide_id',
            'id'
        )->withTrashed();
    }

    public function goodsReceipt() {
        return $this->hasMany(
            GoodsReceipt::class,
            'provide_id',
            'id'
        );


    }
    protected static function newFactory()
    {
        return ProvideFactory::new();
    }

}
