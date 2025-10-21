<?php

namespace Modules\Admin\Provide\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Admin\Provide\src\Models\ProvideDetails;
class ProvideDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1, 40) as $id) {
            ProvideDetails::factory()->create([
                'provide_id' => $id, // bắt buộc set
            ]);
        }
    }
}
