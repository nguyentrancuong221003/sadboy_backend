<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Modules\Admin\Product\src\Models\Product;
use Modules\Admin\Product\src\Policies\ProductPolicy;
use Modules\Admin\Employee\src\Models\Employee;
use Modules\Admin\Employee\src\Policies\EmployeePolicy;
class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Employee::class => EmployeePolicy::class
        //Product::class => ProductPolicy::class
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
