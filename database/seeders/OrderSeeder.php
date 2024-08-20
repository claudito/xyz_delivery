<?php

namespace Database\Seeders;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Order::create([
            'nro_pedido'=>date('Y-m').'-1',
            'fecha_pedido'=> Carbon::now(),
            'status_id' => 1,
        ]);
    }
}
