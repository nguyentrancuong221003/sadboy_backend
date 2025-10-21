<?php

namespace Modules\Admin\Stock\src\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Stock\factories\StockFactory;
class Stock extends Model
{
    use HasFactory;

    protected $table = 'stocks';

    protected $fillable = [
        'code', 'name', 'address', 'phone', 'email'
    ];

    protected static function newFactory()
    {
        return StockFactory::new();
    }
}
