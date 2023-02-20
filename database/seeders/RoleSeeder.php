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
            'nama_role' => 'Karyawan Tingkat 1',
        ]);
        DB::table('role')->insert([
            'nama_role' => 'Karyawan Tingkat 2',
        ]);
        DB::table('role')->insert([
            'nama_role' => 'Direktur',
        ]);
        DB::table('role')->insert([
            'nama_role' => 'HRD',
        ]);
        DB::table('role')->insert([
            'nama_role' => 'Kepala Divisi',
        ]);
    }
}
