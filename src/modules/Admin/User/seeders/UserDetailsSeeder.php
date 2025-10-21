<?php

namespace Modules\Admin\User\seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\User\src\Models\UserDetails;
class UserDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(range(1, 60) as $id) {
            UserDetails::factory()->create([
                'user_id' => $id
            ]);
        }
    }
}
