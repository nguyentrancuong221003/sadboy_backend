<?php

namespace Modules\Admin\Cash_book\src\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Modules\Admin\Cash_book\src\Models\DebtProvides;
use Modules\Admin\Cash_book\src\Models\DebtProvidesMonth;
class TotalDebtProvideMonth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'handle:debt-provide-month';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $year = Carbon::now()->year;
        $month = Carbon::now()->month;

        $total = DebtProvides::whereYear('date', $year)
            ->whereMonth('date', $month)
            ->sum('debt_final');

        DebtProvidesMonth::create([
            'code' => Str::random(15),
            'date' => $year.'-'.$month.'-1',
            'total' => $total,
            'description' => 'Tông kết công nợ của tháng '.$month.' năm '.$year
        ]);
    }
}
