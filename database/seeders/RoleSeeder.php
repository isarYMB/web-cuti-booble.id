<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role')->insert([
            'nama_role' => 'karyawan',
        ]);
        DB::table('role')->insert([
            'nama_role' => 'Leader',
        ]);
        DB::table('role')->insert([
            'nama_role' => 'HRD',
        ]);
        DB::table('role')->insert([
            'nama_role' => 'Kepala Divisi',
        ]);
        DB::table('role')->insert([
            'nama_role' => 'Finance',
        ]);
    }
}
