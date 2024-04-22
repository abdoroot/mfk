<?php

namespace Database\Seeders;

use App\Models\StoreOrder;
use Illuminate\Database\Seeder;

class StoreOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StoreOrder::factory()->count(20)->create();
    }
}
