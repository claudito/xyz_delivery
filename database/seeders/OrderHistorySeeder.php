<?php

namespace Database\Seeders;

use App\Models\OrderHistory;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class OrderHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        OrderHistory::create([
            'order_id' =>1,
            'user_id' => 2,
            'status_id' => 1,
            'fecha_registro' => Carbon::now()
        ]);
    }
}
