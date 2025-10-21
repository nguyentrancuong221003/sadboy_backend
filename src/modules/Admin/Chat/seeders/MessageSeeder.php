<?php

namespace Modules\Admin\Chat\seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\Chat\src\Models\Message;
class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Message::factory()->count(100)->create();
    }
}
