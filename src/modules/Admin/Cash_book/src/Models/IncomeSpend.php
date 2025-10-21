<?php

namespace Modules\Admin\Cash_book\src\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Cash_book\factories\IncomeSpendFactory;

class IncomeSpend extends Model
{
    use HasFactory;

    protected $table = 'income_spend';

    protected $fillable = [
        'code', 'date', 'opening_balance', 'money_in', 'money_out', 'profitable', 'profit_order', 'profit_vote'
    ];

    protected static function newFactory()
    {
        return IncomeSpendFactory::new();
    }
}
