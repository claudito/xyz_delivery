<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $estados = ['Por Atender','En Proceso','En Delivery','Recibido'];

        foreach ($estados as $value) {
            Status::create([
                'name' => $value
            ]);
        }
    }
}
