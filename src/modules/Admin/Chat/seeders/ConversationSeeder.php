<?php

namespace Modules\Admin\Chat\seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\Chat\src\Models\Conversation;
class ConversationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Conversation::factory()->count(40)->create();
    }
}
