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
        //Jabatan

        DB::table('jabatan')->insert([
            'nama_jabatan' => 'Android Developer',
            'id_divisi' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        DB::table('jabatan')->insert([
            'nama_jabatan' => 'Web Developer',
            'id_divisi' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        DB::table('jabatan')->insert([
            'nama_jabatan' => 'Costumer Service',
            'id_divisi' => 2,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        DB::table('jabatan')->insert([
            'nama_jabatan' => 'Sales',
            'id_divisi' => 2,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        DB::table('jabatan')->insert([
            'nama_jabatan' => 'Direktur',
            'id_divisi' => 4,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        DB::table('jabatan')->insert([
            'nama_jabatan' => 'HRD',
            'id_divisi' => 3,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('jabatan')->insert([
            'nama_jabatan' => 'Supervisor Operasional',
            'id_divisi' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('jabatan')->insert([
            'nama_jabatan' => 'Supervisor Marketing',
            'id_divisi' => 2,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        // Divisi

        DB::table('divisi')->insert([
            'nama_divisi' => 'Operasional',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        DB::table('divisi')->insert([
            'nama_divisi' => 'Marketing',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        DB::table('divisi')->insert([
            'nama_divisi' => 'Divisi Support',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        DB::table('divisi')->insert([
            'nama_divisi' => 'Direktur',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
