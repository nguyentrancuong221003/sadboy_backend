<?php

namespace Modules\Admin\Cash_book\src\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Cash_book\factories\ProfitableFactory;
class Profitable extends Model
{
    use HasFactory;

    protected $table ='profitable';

    protected static function newFactory()
    {
        return ProfitableFactory::new();
    }
}
