<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('statuses')->insert([
            [
                'status' => 'Review Rekanan Vendor',
            ],
            [
                'status' => 'Review Buyer',
            ],
            [
                'status' => 'Review Hukum',
            ],
            [
                'status' => 'Approve Hukum',
            ],
            [
                'status' => 'ACC By AVP',
            ],
            [
                'status' => 'ACC By VP',
            ],
            [
                'status' => 'ACC By SVP',
            ],
            [
                'status' => 'ACC By DKU',
            ],
            [
                'status' => 'APPROVED',
            ],
            [
                'status' => 'Tanda Tangan Kontrak',
            ],
            [
                'status' => 'Review Final Kontrak',
            ],
            [
                'status' => 'ACC Final Kontrak',
            ],
        ]);
    }
}
