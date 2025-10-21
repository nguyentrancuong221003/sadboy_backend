<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
class MakeModuleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tạo một module mới trong thư mục modules';

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
        $name = $this->argument('name');
        $path = base_path("modules/{$name}");
        if (File::exists($path)) {
            $this->error("Module '{$name}' đã tồn tại!");
            return;
        }

        $folders = ['configs', 'helpers', 'migrations', 'resources', 'routes', 'src', 'factories', 'seeders'];
        foreach ($folders as $folder) {
            File::makeDirectory("{$path}/{$folder}", 0755, true);
        }

        $pathResources = base_path("modules/{$name}/resources");
        $foldersResources = ['lang', 'views'];
        if(File::exists($pathResources) ) {
            foreach($foldersResources as $folder) {
                File::makeDirectory("$pathResources/{$folder}", 0755, true);
            }
        }

        $pathSrc = base_path("modules/{$name}/src");
        $folderSrc = ['Commands', 'Http', 'Jobs', 'Models', 'Policies' ,'Repositories'];
        if(File::exists($pathSrc)){
            foreach($folderSrc as $folder) {
                File::makeDirectory("$pathSrc/{$folder}", 0755, true);
            }
        }

        $pathSrcHttp = base_path("modules/{$name}/src/Http");
        $folderSrcHttp = ['Controllers', 'Middlewares', 'Requests'];
        if(File::exists($pathSrcHttp)) {
            foreach($folderSrcHttp as $folder) {
                File::makeDirectory("$pathSrcHttp/{$folder}", 0755, true);
            }
        }

        //phần này là tạo file
        $pathRoutesFile = base_path("modules/{$name}/routes");
        $pathRoutesFile = base_path("modules/{$name}/routes");
        $routeFiles = ['api.php', 'web.php', 'routes.php'];

        // Tạo thư mục routes nếu chưa tồn tại
        if (!File::exists($pathRoutesFile)) {
            File::makeDirectory($pathRoutesFile, 0755, true);
        }

        // Nội dung route
        $contentRouteFile = <<<PHP
        <?php

        use Illuminate\\Support\\Facades\\Route;

        Route::get('/{$name}', function () {
            return 'Đây là module {$name}';
        });
        PHP;

        // Tạo các file route
        foreach ($routeFiles as $file) {
            File::put("{$pathRoutesFile}/{$file}", $contentRouteFile);
        }
        //File::put($routesFile, $routesContent);
        $this->info("Module '{$name}' đã được tạo tại: {$path}");
    }
}
