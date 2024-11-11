<?php

namespace Modules\Lottery\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Lottery\Models\Lottery;

class LotterySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Lottery::factory()->count(10)->create();
    }
}

