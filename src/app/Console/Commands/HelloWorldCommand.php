<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class HelloWorldCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hello:world {name=Guest}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'In ra Hello World với tên bạn truyền vào';

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
        $name = $this->argument('name'); // lấy tham số
        $this->info("Hello, {$name}! 🎉");

        return Command::SUCCESS;
    }
}
