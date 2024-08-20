<?php

namespace Database\Seeders;

use App\Models\OrderDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        OrderDetail::create([
            'order_id' =>1,
            'sku' =>'2676634',
            'nombre' => 'Blusa Faby',
            'tipo' => 'Blusas',
            'etiquetas' => 'animal print, invierno',
            'unidad_medida' => 'und',
            'precio' => '48.00'
        ]);

        OrderDetail::create([
            'order_id' =>1,
            'sku' =>'3241175',
            'nombre' => 'Vestido Mia',
            'tipo' => 'Vestido',
            'etiquetas' => 'flores',
            'unidad_medida' => 'und',
            'precio' => '99.00'
        ]);

        OrderDetail::create([
            'order_id' =>1,
            'sku' =>'7898087',
            'nombre' => 'Pantalón Luna',
            'tipo' => 'Pantalones',
            'etiquetas' => 'otoño, oferta',
            'unidad_medida' => 'und',
            'precio' => '95.00'
        ]);

    }
}
