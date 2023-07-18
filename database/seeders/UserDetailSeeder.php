<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_details')->insert([
            [
                'user_id' => 1,
                'role_id' => 1,
                'unit_id' => 1,
                'department_id' => 1,
                'email' => 'buyer@gmail.com',
                'phone' => '08123456789',
            ],
            [
                'user_id' => 2,
                'role_id' => 1,
                'unit_id' => 1,
                'department_id' => 1,
                'email' => 'buyer@gmail.com',
                'phone' => '08123456789',
            ],
            [
                'user_id' => 3,
                'role_id' => 1,
                'unit_id' => 1,
                'department_id' => 1,
                'email' => 'buyer@gmail.com',
                'phone' => '08123456789',
            ],
            [
                'user_id' => 4,
                'role_id' => 3,
                'unit_id' => null,
                'department_id' => 2,
                'email' => 'legal@gmail.com',
                'phone' => '08123456789',
            ],
            [
                'user_id' => 5,
                'role_id' => 4,
                'unit_id' => 1,
                'department_id' => 1,
                'email' => 'avpjasa@gmail.com',
                'phone' => '08123456789',
            ],
            [
                'user_id' => 6,
                'role_id' => 5,
                'unit_id' => null,
                'department_id' => 1,
                'email' => 'vpjasa@gmail.com',
                'phone' => '08123456789',
            ],
            [
                'user_id' => 7,
                'role_id' => 6,
                'unit_id' => null,
                'department_id' => null,
                'email' => 'svpteknik@gmail.com',
                'phone' => '08123456789',
            ],
            [
                'user_id' => 8,
                'role_id' => 7,
                'unit_id' => null,
                'department_id' => null,
                'email' => 'dku@gmail.com',
                'phone' => '08123456789',
            ],
            [
                'user_id' => 9,
                'role_id' => 2,
                'unit_id' => null,
                'department_id' => null,
                'email' => 'suryabuana@gmail.com',
                'phone' => '08123456789',
            ],
            [
                'user_id' => 10,
                'role_id' => 2,
                'unit_id' => null,
                'department_id' => null,
                'email' => 'gcs@gmail.com',
                'phone' => '08123456789',
            ],
        ]);
    }
}
