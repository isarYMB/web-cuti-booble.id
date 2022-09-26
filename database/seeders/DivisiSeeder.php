<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
// use App\Models\Divisi;
// use App\Models\Jabatan;
// use Hash;

class DivisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */

    public function run()
    {
        DB::table('jabatan')->insert([
            'nama_jabatan' => 'Android Developer',
            'id_divisi' => 1,
        ]);
        DB::table('jabatan')->insert([
            'nama_jabatan' => 'Web Developer',
            'id_divisi' => 1,
        ]);
        DB::table('jabatan')->insert([
            'nama_jabatan' => 'Costumer Service',
            'id_divisi' => 2,
        ]);
        DB::table('jabatan')->insert([
            'nama_jabatan' => 'Akuntansi',
            'id_divisi' => 3,
        ]);

        DB::table('divisi')->insert([
            'nama_divisi' => 'Operasional',
        ]);
        DB::table('divisi')->insert([
            'nama_divisi' => 'Sales',
        ]);
        DB::table('divisi')->insert([
            'nama_divisi' => 'Akuntan',
        ]);
    }
}
