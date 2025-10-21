<?php

namespace Modules\Admin\Cash_book\src\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Cash_book\factories\DebtProvideFactory;
class DebtProvides extends Model
{
    use HasFactory;

    protected $table = 'debt_provides';

    protected $fillable = [
        'code', 'date', 'initial_debt', 'debt_arises', 'debt_paid', 'debt_final'
    ];

    protected static function newFactory()
    {
        return DebtProvideFactory::new();
    }
}
