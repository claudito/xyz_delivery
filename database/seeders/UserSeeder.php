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
            'password' => Hash::make('password'),
            'position' => 'Encargado'
        ]);
        $user1->assignRole('Encargado');

        $user2 = User::create([
            'code' => '0002',
            'name' => 'Ashton Cox',
            'email' => 'vendedor1@xyzboutique.com',
            'password' => Hash::make('password'),
            'position' => 'Vendedor'
        ]);
        $user2->assignRole('Vendedor');

        $user3 = User::create([
            'code' => '0003',
            'name' => 'Yuri Berry',
            'email' => 'vendedor2@xyzboutique.com',
            'password' => Hash::make('password'),
            'position' => 'Vendedor'
        ]);
        $user3->assignRole('Vendedor');


        $user4 = User::create([
            'code' => '0004',
            'name' => 'Bruno Nash',
            'email' => 'repartidor1@xyzboutique.com',
            'password' => Hash::make('password'),
            'position' => 'Repartidor'
        ]);
        $user4->assignRole('Repartidor');

        $user5 = User::create([
            'code' => '0005',
            'name' => 'Paul Byrd',
            'email' => 'repartidor2@xyzboutique.com',
            'password' => Hash::make('password'),
            'position' => 'Repartidor'
        ]);
        $user5->assignRole('Repartidor');
    }
}
