<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use Modules\Admin\Comment\src\Models\Comment;

use Carbon\Carbon;
use Modules\Admin\Order\src\Models\OrderPending;
use Modules\Admin\Order\src\Models\Order;
use Modules\Admin\Order\src\Models\OrderSuccess;
use Modules\Admin\Product\src\Models\Product;
use Illuminate\Support\Str;
use Modules\Admin\Cash_book\src\Models\BillCollectSpend;
use Modules\Admin\Cash_book\src\Models\IncomeSpend;
use Modules\Admin\Cash_book\src\Models\DebtProvides;
use Modules\Admin\Cash_book\src\Models\DebtProvidesMonth;
use App\Events\SendEmailUserCreateAccount;



Route::get('/me', function () {
    return 111;
});
