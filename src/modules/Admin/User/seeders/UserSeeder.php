<?php

namespace Modules\Admin\User\seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\User\src\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(60)->create();
    }
}
