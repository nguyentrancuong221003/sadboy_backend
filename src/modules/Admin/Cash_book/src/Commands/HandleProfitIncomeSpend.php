<?php

namespace Modules\Admin\Cash_book\src\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;

use Modules\Admin\Order\src\Models\OrderSuccess;
use Illuminate\Support\Str;
use Modules\Admin\Cash_book\src\Models\BillCollectSpend;
use Modules\Admin\Cash_book\src\Models\IncomeSpend;
class HandleProfitIncomeSpend extends Command
{
    protected $signature = 'handle:profit-income-spend';

    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $date = Carbon::now()->format('Y-m-d');
        $money_in = BillCollectSpend::where('type', 'collect')
        ->whereDate('created_at', $date)
        ->sum('money');

        $money_out = BillCollectSpend::where('type', 'spend')
        ->whereDate('created_at', $date)
        ->sum('money');

        $profit_order = OrderSuccess::whereDate('created_at', $date)
        ->sum('total_profitable_price');

        $profit_vote = $money_in - $money_out;

        $Income =IncomeSpend::whereDate('date', Carbon::yesterday())->first();
        $opening_balance = $Income->profitable ?? 0;

        $profitable = $opening_balance + $money_in + $profit_order + $profit_vote - $money_out;

        IncomeSpend::create([
            'code' => Str::random(10),
            'date' => $date,
            'opening_balance' => $opening_balance,
            'money_in' => $money_in,
            'money_out' => $money_out,
            'profitable' => $profitable,
            'profit_order' => $profit_order,
            'profit_vote' => $profit_vote
        ]);
    }
}
