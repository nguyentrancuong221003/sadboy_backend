<?php

namespace Modules\Admin\Provide\src\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Provide\factories\ProvideDetailsFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Admin\Provide\src\Models\Provide;
class ProvideDetails extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'total_order', 'return_order', 'total_buy', 'total_debt', 'bank',
        'account_name', 'account_phone', 'qr_img'
    ];

    protected $table = 'provide_details';

    public function provide() {
        return $this->belongsTo(
            Provide::class,
            'provide_id',
            'id'
        );
    }
    protected static function newFactory()
    {
        return ProvideDetailsFactory::new();
    }
}
