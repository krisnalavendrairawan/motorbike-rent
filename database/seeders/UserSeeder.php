<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Customer;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(
            [
                'nik' => null,
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('password'),
                'phone' => '081234567890',
                'address' => null,
                'gender' => 'male',
                'driverLicense' => null,
                'created_by' => null,
            ]
        )->assignRole('admin');

        User::create([
            'nik' => '3211145678909876',
            'name' => 'customer1',
            'email' => 'customer1@gmail.com',
            'password' => bcrypt('password'),
            'address' => 'Jln. Gatot Subroto, No. 123, Kecamatan Sawangan, Kabupaten Bandung',
            'gender' => 'male',
            'driverLicense' => '11130598098762',
            'phone' => '082345678901',
            'created_by' => null,

        ])->assignRole('customer');
    }
}
