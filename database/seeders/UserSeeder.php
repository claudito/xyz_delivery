<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $user1 = User::create([
            'code' => '0001',
            'name' => 'Airi Satou',
            'email' => 'encargado@xyzboutique.com',
            'password' => Hash::make('12345678'),
            'position' => 'Encargado',
            'phone' => '+519'.random_int(10000000, 99999999),
        ]);
        $user1->assignRole('Encargado');

        $user2 = User::create([
            'code' => '0002',
            'name' => 'Ashton Cox',
            'email' => 'vendedor1@xyzboutique.com',
            'password' => Hash::make('12345678'),
            'position' => 'Vendedor',
            'phone' => '+519'.random_int(10000000, 99999999),
        ]);
        $user2->assignRole('Vendedor');

        $user3 = User::create([
            'code' => '0003',
            'name' => 'Yuri Berry',
            'email' => 'vendedor2@xyzboutique.com',
            'password' => Hash::make('12345678'),
            'position' => 'Vendedor',
            'phone' => '+519'.random_int(10000000, 99999999),
        ]);
        $user3->assignRole('Vendedor');


        $user4 = User::create([
            'code' => '0004',
            'name' => 'Bruno Nash',
            'email' => 'repartidor1@xyzboutique.com',
            'password' => Hash::make('12345678'),
            'position' => 'Repartidor',
            'phone' => '+519'.random_int(10000000, 99999999),
        ]);
        $user4->assignRole('Repartidor');

        $user5 = User::create([
            'code' => '0005',
            'name' => 'Paul Byrd',
            'email' => 'repartidor2@xyzboutique.com',
            'password' => Hash::make('12345678'),
            'position' => 'Repartidor',
            'phone' => '+519'.random_int(10000000, 99999999),
        ]);
        $user5->assignRole('Repartidor');
    }
}
