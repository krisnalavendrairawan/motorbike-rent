<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'create user']);
        Permission::create(['name' => 'update user']);
        Permission::create(['name' => 'delete user']);

        Permission::create(['name' => 'create role']);
        Permission::create(['name' => 'update role']);
        Permission::create(['name' => 'delete role']);

        Permission::create(['name' => 'create motor']);
        Permission::create(['name' => 'update motor']);
        Permission::create(['name' => 'delete motor']);

        Permission::create(['name' => 'create maintenance']);
        Permission::create(['name' => 'update maintenance']);
        Permission::create(['name' => 'delete maintenance']);

        Permission::create(['name' => 'create rental']);
        Permission::create(['name' => 'update rental']);
        Permission::create(['name' => 'delete rental']);

        Permission::create(['name' => 'create transaction']);

        Role::create(['name' => 'admin']);
        Role::create(['name' => 'customer']);
        $roleAdmin = Role::findByName('admin');
        $roleAdmin->givePermissionTo(Permission::all());
        $roleCustomer = Role::findByName('customer');
        $roleCustomer->givePermissionTo([
            'create rental',
            'update rental',
            'delete rental',
            'create transaction',
        ]);
    }
}
