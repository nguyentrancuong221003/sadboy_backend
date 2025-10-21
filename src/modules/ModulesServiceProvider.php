<?php
namespace Modules;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;
//use Modules\Admin\User\src\Http\Middlewares\DemoMiddleware;
//use Modules\Admin\User\src\Commands\TestCommand;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;

use Modules\Admin\Employee\src\Http\Middlewares\JwtFromCookieEmployee;
use Modules\client\Account\src\Http\Middlewares\JwtFromCookieUser;

use Modules\Admin\User\src\Repositories\UserRepositoryInterface;
use Modules\Admin\User\src\Repositories\UserRepository;
use Modules\Admin\Employee\src\Repositories\EmployeeRepositoryInterface;
use Modules\Admin\Employee\src\Repositories\EmployeeRepository;
use Modules\Admin\Order\src\Repositories\OrderRepositoryInterface;
use Modules\Admin\Order\src\Repositories\OrderRepository;
use Modules\Admin\Product\src\Repositories\ProductRepositoryInterface;
use Modules\Admin\Product\src\Repositories\ProductRepository;
use Modules\Admin\Comment\src\Repositories\CommentRepositoryInterface;
use Modules\Admin\Comment\src\Repositories\CommentRepository;
use Modules\Admin\Voucher\src\Repositories\VoucherRepositoryInterface;
use Modules\Admin\Voucher\src\Repositories\VoucherRepository;
use Modules\Admin\Provide\src\Repositories\ProvideRepositoryInterface;
use Modules\Admin\Provide\src\Repositories\ProvideRepository;
use Modules\Admin\Cash_book\src\Repositories\CashBookRepositoryInterface;
use Modules\Admin\Cash_book\src\Repositories\CashBookRepository;
use Modules\Admin\Stock\src\Repositories\StockRepositoryInterface;
use Modules\Admin\Stock\src\Repositories\StockRepository;
use Modules\Admin\Dashboard\src\Repositories\DashboardRepositoryInterface;
use Modules\Admin\Dashboard\src\Repositories\DashboardRepository;
use Modules\Client\Cart\src\Repositories\CartRepositoryInterface;
use Modules\Client\Cart\src\Repositories\CartRepository;
use Modules\Client\Comment\src\Repositories\ClientCommentRepositoryInterface;
use Modules\Client\Comment\src\Repositories\ClientCommentRepository;
use Modules\Client\Account\src\Repositories\ClientUserRepositoryInterface;
use Modules\Client\Account\src\Repositories\ClientUserRepository;
use Modules\Client\Product\src\Repositories\ClientProductRepositoryInterface;
use Modules\Client\Product\src\Repositories\ClientProductRepository;
use Modules\Client\Order\src\Repositories\ClientOrderRepositoryInterface;
use Modules\Client\Order\src\Repositories\ClientOrderRepository;
use Modules\Client\Voucher\src\Repositories\ClientVoucherRepositoryInterface;
use Modules\Client\Voucher\src\Repositories\ClientVoucherRepository;

use Modules\Admin\Order\src\Commands\DeleteOrderPending;
use Modules\Admin\Order\src\Commands\HandleProfitOrder;
use Modules\Admin\Cash_book\src\Commands\HandleProfitIncomeSpend;
use Modules\Admin\Cash_book\src\Commands\TotalDebtProvideMonth;
use Modules\Admin\Cash_book\src\Commands\HandleDebtProvideDaily;
class ModulesServiceProvider extends ServiceProvider {
    private $middlewares = [
        'jwt.cookie.user' => JwtFromCookieUser::class,
        'jwt.cookie.employee' => JwtFromCookieEmployee::class
    ];
    private $commands =[
        DeleteOrderPending::class,
        HandleProfitOrder::class,
        HandleProfitIncomeSpend::class,
        TotalDebtProvideMonth::class,
        HandleDebtProvideDaily::class

    ];
    public function boot(){
        $modules = $this->getModules();
        if(!empty($modules)){
            foreach($modules as $mainModule => $subModules){
                foreach($subModules as $subModule){
                    $this->registerModule($mainModule . '/' . $subModule);
                }
            }
        }

        // Dòng này để load policy
        $this->registerPolicies();
    }
    public function register() {
        //config
        $modules = $this->getModules();
        if(!empty($modules)){
            foreach($modules as $mainModule => $subModules){
                foreach($subModules as $subModule){
                    $this->registerConfig($mainModule . '/' . $subModule);
                }
            }
        }

        //middleware
        $this->registerMiddlewares();

        //commands
        $this->commands($this->commands);

        $this->app->singleton(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->singleton(
            EmployeeRepositoryInterface::class,
            EmployeeRepository::class
        );

        $this->app->singleton(
            OrderRepositoryInterface::class,
            OrderRepository::class
        );

        $this->app->singleton(
            ProductRepositoryInterface::class,
            ProductRepository::class
        );

        $this->app->singleton(
            CommentRepositoryInterface::class,
            CommentRepository::class
        );

        $this->app->singleton(
            VoucherRepositoryInterface::class,
            VoucherRepository::class
        );

        $this->app->singleton(
            ProvideRepositoryInterface::class,
            ProvideRepository::class
        );

        $this->app->singleton(
            CashBookRepositoryInterface::class,
            CashBookRepository::class
        );

        $this->app->singleton(
            StockRepositoryInterface::class,
            StockRepository::class
        );

        $this->app->singleton(
            DashboardRepositoryInterface::class,
            DashboardRepository::class
        );

        $this->app->singleton(
            CartRepositoryInterface::class,
            CartRepository::class
        );

        $this->app->singleton(
            ClientCommentRepositoryInterface::class,
            ClientCommentRepository::class
        );

        $this->app->singleton(
            ClientUserRepositoryInterface::class,
            ClientUserRepository::class
        );

        $this->app->singleton(
            ClientProductRepositoryInterface::class,
            ClientProductRepository::class
        );

        $this->app->singleton(
            ClientOrderRepositoryInterface::class,
            ClientOrderRepository::class
        );

        $this->app->singleton(
            ClientVoucherRepositoryInterface::class,
            ClientVoucherRepository::class
        );

    }

    private function getModules(){
        $modules = [];

        // Lấy danh sách module chính (Admin, Client)
        $mainModules = File::directories(__DIR__);

        foreach ($mainModules as $mainModule) {
            $mainModuleName = basename($mainModule);

            // Tìm các module con trong module chính
            $subModules = File::directories($mainModule);
            $modules[$mainModuleName] = array_map('basename', $subModules);
        }

        return $modules;
    }
    private function registerModule($module){
        $modulePath = __DIR__."/{$module}";

        //khai báo route
        if(File::exists($modulePath."/routes")) {
            $this->registerRoute($modulePath);
        }

        //khai báo migrations
        if(File::exists($modulePath."/migrations")) {
            $this->registerMigration($modulePath);
        }

        //khai báo language
        if(File::exists($modulePath."/resources/lang")) {
            $this->loadTranslationsFrom($modulePath."/resources/lang", $module);
            $this->loadJsonTranslationsFrom($modulePath."/resources/lang");
        }

        //khai báo view
        if(File::exists($modulePath."/resources/views")) {
            $this->loadViewsFrom($modulePath."/resources/views", $module);
        }

        //khai báo helper
        if(File::exists($modulePath."/helpers")) {
            $this->registerHelper($modulePath);
        }

        //khai báo seeder
        if (File::exists($modulePath . "/seeders")) {
            $this->registerSeeder($modulePath);
        }
    }
    private function registerRoute($modulePath){
        $routesPath = $modulePath . "/routes";
        $routeFiles = File::allFiles($routesPath);
        foreach ($routeFiles as $routeFile) {
            $filename = $routeFile->getFilename();
            if ($filename === 'api.php') {
                Route::middleware('api')
                    ->prefix('api')
                    ->group($routeFile->getPathname());
            } else {
                //nó sẽ ko có middleware web măc đinh, thì sẽ ko làm viêc được với session....
                $this->loadRoutesFrom($routeFile->getPathname());
            }

        }
    }
    private function registerMigration($modulePath){
        $migrationsPath = $modulePath . "/migrations";
        $this->loadMigrationsFrom($migrationsPath);
    }
    private function registerSeeder($modulePath)
    {
        $seederPath = $modulePath . "/seeders";
        $seederFiles = File::allFiles($seederPath);
        foreach ($seederFiles as $seederFile) {
            $file = $seederFile->getPathname();
            require_once $file;
        }
    }
    private function registerHelper($modulePath){
        //modules khác cũng truy câp được nhé
        $helperList= File::allFiles($modulePath."/helpers");
        if(!empty($helperList)){
            foreach($helperList as $helper){
                $file= $helper->getPathname();
                require $file;
            }
        }
    }
    private function registerConfig($module){
        $configPath=__DIR__.'/'.$module.'/configs';
        if(File::exists($configPath)){
            $configFiles = array_map('basename', File::allFiles($configPath));
            foreach($configFiles as $config){
                $alias= basename($config, '.php');
                $this->mergeConfigFrom($configPath.'/'.$config, $alias);
            }
        }
    }
    private function registerMiddlewares(){
        if(!empty($this->middlewares) ) {
            foreach($this->middlewares as $key => $middleware) {
                $this->app['router']->pushMiddlewareToGroup($key, $middleware);
            }
        }
    }

    private function registerPolicies()
    {
        $modules = $this->getModules();
        foreach ($modules as $mainModule => $subModules) {
            foreach ($subModules as $subModule) {
                $policyPath = __DIR__ . "/{$mainModule}/{$subModule}/src/Policies";
                if (File::exists($policyPath)) {
                    $policyFiles = File::allFiles($policyPath);
                    foreach ($policyFiles as $file) {
                        $className = pathinfo($file->getFilename(), PATHINFO_FILENAME);
                        $policyClass = "Modules\\{$mainModule}\\{$subModule}\\src\\Policies\\{$className}";
                        if (class_exists($policyClass)) {
                            // Ví dụ ProductPolicy -> Product
                            $modelName = str_replace('Policy', '', $className);
                            $modelClass = "Modules\\{$mainModule}\\{$subModule}\\src\\Models\\{$modelName}";

                            if (class_exists($modelClass)) {
                                Gate::policy($modelClass, $policyClass);
                            }
                        }
                    }
                }
            }
        }
    }
}

