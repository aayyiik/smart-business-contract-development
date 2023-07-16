<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Bagus Permadi Ardiansyah',
                'nik' => '2325736',
                'password' => Hash::make('distribusi1'),
                'status' => '1',
            ],
            [
                'name' => 'Indra Riyan Permana',
                'nik' => '2325738',
                'password' => Hash::make('distribusi1'),
                'status' => '1'
            ],
            [
                'name' => 'Faisal Z Nasrulloh',
                'nik' => '2146191',
                'password' => Hash::make('distribusi1'),
                'status' => '1'
            ],
            [
                'name' => 'Karina Sari',
                'nik' => '2084865',
                'password' => Hash::make('legal1'),
                'status' => '1'
            ],
            [
                'name' => 'Akhmad Ali Affandi',
                'nik' => '',
                'password' => Hash::make('avpdistribusi1'),
                'status' => '1',
            ],
            [
                'name' => 'Haris Sulistiyana',
                'nik' => '',
                'password' => Hash::make('vpjasa1'),
                'status' => '1',
            ],
            [
                'name' => 'I Gusti Manacika',
                'nik' => '',
                'password' => Hash::make('svpteknik1'),
                'status' => '1',
            ],
            [
                'name' => 'Budi Wahyu Soesilo',
                'nik' => '',
                'password' => Hash::make('dku1'),
                'status' => '1',
            ],
            [
                'name' => 'Indarto Widjanto',
                'nik' => '010101',
                'password'=> Hash::make('suryabuana1'),
                'status' => '1',
            ],
            [
                'name' => 'Handoko',
                'nik' => '010102',
                'password' => Hash::make('gcs1'),
                'status' => '1',
            ],
        ];

           // Tambahkan data user_details sesuai dengan data pengguna
           foreach ($users as $user) {
            $userData = User::create($user);

            UserDetail::create([
                'user_id' => $userData->id,
                'role_id' => '',
                'unit_id' => '',
                'department_id' => '',
                'email' => 'bagus@gmail.com',
                'phone' => '081234567890',
            ]);
        }
    }
}
