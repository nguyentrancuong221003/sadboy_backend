<?php

namespace App\Listeners;

use App\Events\SendEmailUserCreateAccount;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
class SendMailToUser
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\SendEmailUserCreateAccount  $event
     * @return void
     */
    public function handle(SendEmailUserCreateAccount $event)
    {
        Log::info('🎉 Listener SendMailToUser đã chạy thành công lúc: ' . now());
    }
}
