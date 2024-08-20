<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $role1 = Role::create(['name' => 'Encargado']);
        $role2 = Role::create(['name' => 'Vendedor']);
        $role3 = Role::create(['name' => 'Delivery']);
        $role4 = Role::create(['name' => 'Repartidor']);
    }
}
