<?php

namespace Modules\Admin\Cash_book\src\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Modules\Admin\Cash_book\src\Models\DebtProvides;
class HandleDebtProvideDaily extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'handle:debt-provide-daily';

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
        $date = Carbon::now()->format('Y-m-d');
        $debt = DebtProvides::latest()->first();

        $initial_debt = $debt->debt_final;

        DebtProvides::create([
            'code' => Str::random(10),
            'date' => $date,
            'initial_debt' => $initial_debt,
            'debt_arises' => 0,
            'debt_paid' => 0,
            'debt_final' => 0
        ]);
    }
}
