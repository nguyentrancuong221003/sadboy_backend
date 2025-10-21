<?php

namespace Modules\Admin\Cash_book\src\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Cash_book\factories\DebtProvideMonthFactory;

class DebtProvidesMonth extends Model
{
    use HasFactory;

    protected $table = 'debt_provides_month';

    protected $fillable = [
        'code', 'date', 'total', 'description'
    ];

    protected static function newFactory()
    {
        return DebtProvideMonthFactory::new();
    }
}
