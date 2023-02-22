<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Karyawan;
use Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User
        // $user = User::create([
        //     'name' => 'Bahrul Ulum',
        //     'email' => 'bahrul@gmail.com',
        //     'password' => Hash::make("bahrul"),
        //     'role' => 'Karyawan Tingkat 2',
        //     'nik' => 9832894389456234,
        //     'no_telpon' => 628967567543,
        // ]);

        // $user = User::create([
        //     'name' => 'Maghfira',
        //     'email' => 'maghfira@example.com',
        //     'password' => Hash::make("maghfira"),
        //     'role' => 'Karyawan Tingkat 1',
        //     'nik' => 9832894389456234,
        //     'no_telpon' => 628967567543,
        // ]);

        // $user = User::create([
        //     'name' => 'Alwali',
        //     'email' => 'alwali@example.com',
        //     'password' => Hash::make("alwali"),
        //     'role' => 'Karyawan Tingkat 1',
        //     'nik' => 9832894389456234,
        //     'no_telpon' => 628967567543,
        // ]);

        // $user = User::create([
        //     'name' => 'Amriana Tonang',
        //     'email' => 'amriana@example.com',
        //     'password' => Hash::make("amriana"),
        //     'role' => 'Karyawan Tingkat 1',
        //     'nik' => 9832894389456234,
        //     'no_telpon' => 628967567543,
        // ]);

        // $user = User::create([
        //     'name' => 'Firdha Andirah',
        //     'email' => 'firdah@example.com',
        //     'password' => Hash::make("firdha"),
        //     'role' => 'Karyawan Tingkat 1',
        //     'nik' => 9832894389456234,
        //     'no_telpon' => 628967567543,
        // ]);

        // $user = User::create([
        //     'name' => 'Sukraini M Nur',
        //     'email' => 'sukraini@example.com',
        //     'password' => Hash::make("sukraini"),
        //     'role' => 'Kepala Divisi',
        //     'nik' => 9832894389456234,
        //     'no_telpon' => 628967567543,
        // ]);

        $user = User::create([
            'name' => 'Yulia Citra ',
            'email' => 'citra@example.com',
            'password' => Hash::make("citra"),
            'role' => 'HRD',
            'nik' => 9832894389456234,
            'no_telpon' => 628967567543,
        ]);

        // $user = User::create([
        //     'name' => 'Rudianto',
        //     'email' => 'rudianto@example.com',
        //     'password' => Hash::make("rudianto"),
        //     'role' => 'Direktur',
        //     'nik' => 9832894389456234,
        //     'no_telpon' => 628967567543,
        // ]);

        // $user = User::create([
        //     'name' => 'Ashari Widodo',
        //     'email' => 'ashari@example.com',
        //     'password' => Hash::make("ashari"),
        //     'role' => 'Kepala Divisi',
        //     'nik' => 9832894389456234,
        //     'no_telpon' => 628967567543,
        // ]);

        // $user = User::create([
        //     'name' => 'Ahmad Muflih',
        //     'email' => 'muflih@example.com',
        //     'password' => Hash::make("muflih"),
        //     'role' => 'Kepala Divisi',
        //     'nik' => 9832894389456234,
        //     'no_telpon' => 628967567543,
        // ]);


        // Karyawan

        // $user = Karyawan::create([
        //     'user_id' => '1',
        //     'jumlah_cuti' => 12,
        //     'divisi' => 'Operasional',
        //     'jabatan' => 'Android Developer',
        // ]);

        // $user = Karyawan::create([
        //     'user_id' => '2',
        //     'jumlah_cuti' => 12,
        //     'divisi' => 'Operasional',
        //     'jabatan' => 'Web Developer',
        // ]);

        // $user = Karyawan::create([
        //     'user_id' => '3',
        //     'jumlah_cuti' => 12,
        //     'divisi' => 'Marketing',
        //     'jabatan' => 'Marketing Division',
        // ]);

        // $user = Karyawan::create([
        //     'user_id' => '4',
        //     'jumlah_cuti' => 12,
        //     'divisi' => 'Marketing',
        //     'jabatan' => 'Marketing Division',
        // ]);

        // $user = Karyawan::create([
        //     'user_id' => '5',
        //     'jumlah_cuti' => 12,
        //     'divisi' => 'Marketing',
        //     'jabatan' => 'Sales',
        // ]);

        // $user = Karyawan::create([
        //     'user_id' => '6',
        //     'jumlah_cuti' => 12,
        //     'divisi' => 'Divisi Support',
        //     'jabatan' => 'Finance',
        // ]);

        $user = Karyawan::create([
            'user_id' => '1',
            'jumlah_cuti' => 12,
            'divisi' => 'Divisi Support',
            'jabatan' => 'HRD',
        ]);

        // $user = Karyawan::create([
        //     'user_id' => '8',
        //     'jumlah_cuti' => 12,
        //     'divisi' => 'Direktur',
        //     'jabatan' => 'Direktur',
        // ]);

        // $user = Karyawan::create([
        //     'user_id' => '9',
        //     'jumlah_cuti' => 12,
        //     'divisi' => 'Marketing',
        //     'jabatan' => 'Supervisor Marketing',
        // ]);

        // $user = Karyawan::create([
        //     'user_id' => '10',
        //     'jumlah_cuti' => 12,
        //     'divisi' => 'Operasional',
        //     'jabatan' => 'Supervisor Operasional',
        // ]);

        // Super Admin


    }
}
