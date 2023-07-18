<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vendors')->insert([
            [
                'user_detail_id' => 9,
                'vendor' => 'SURYA BUANA SENTOSA',
                'no_sap' => '1000000308',
                'no_eproc' => '00000088',
                'phone' => '0313294043',
                'address' => 'Jl. Perak Timur 220 - Perak Utara - Pabean Cantian'
            ],
            [
                'user_detail_id' => 10,
                'vendor' => 'GRESIK CIPTA SEJAHTERA',
                'no_sap' => '4000000019',
                'no_eproc' => '00000765',
                'phone' => '0313985543',
                'address' => 'Jl KIG Raya Selatan Blok A-5 Kawasan Industri Gresik'
            ],
        ]);
    }
}
