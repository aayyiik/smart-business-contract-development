<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        DB::table('users')->insert([
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
                'nik' => '2105091',
                'password' => Hash::make('avpdistribusi1'),
                'status' => '1',
            ],
            [
                'name' => 'Haris Sulistiyana',
                'nik' => '2944780',
                'password' => Hash::make('vpjasa1'),
                'status' => '1',
            ],
            [
                'name' => 'I Gusti Manacika',
                'nik' => '2944769',
                'password' => Hash::make('svpteknik1'),
                'status' => '1',
            ],
            [
                'name' => 'Budi Wahyu Soesilo',
                'nik' => '2210019',
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
        ]);

    }
}
