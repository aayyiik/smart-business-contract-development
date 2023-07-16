<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert([
            [
                'departement' => 'Pengadaan Jasa',
            ],
            [
                'department' => 'Legal',
            ],
            [
                'department' => 'PPBJ'
            ],
            ]);
    }
}
