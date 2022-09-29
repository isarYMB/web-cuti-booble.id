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
        // Karyawan
        $user = User::create([
            'name' => 'Yishcard',
            'email' => 'yischard@example.com',
            'password' => Hash::make("yischardweb"),
            'role' => 'karyawan',
            'nik' => 1231234,
            'no_telpon' => 628967567543,
        ]);
        
        $user = User::create([
            'name' => 'Maghfira',
            'email' => 'maghfira@example.com',
            'password' => Hash::make("maghfiraweb"),
            'role' => 'karyawan',
            'nik' => 1231234,
            'no_telpon' => 628967567543,
        ]);
        
        $user = User::create([
            'name' => 'Alwali',
            'email' => 'alwali@example.com',
            'password' => Hash::make("alwaliweb"),
            'role' => 'karyawan',
            'nik' => 1231234,
            'no_telpon' => 628967567543,
        ]);

        $user = User::create([
            'name' => 'Affiq',
            'email' => 'affiq@example.com',
            'password' => Hash::make("affiqweb"),
            'role' => 'karyawan',
            'nik' => 1231234,
            'no_telpon' => 628967567543,
        ]);

        $user = User::create([
            'name' => 'Annas',
            'email' => 'annas@example.com',
            'password' => Hash::make("annasweb"),
            'role' => 'karyawan',
            'nik' => 1231234,
            'no_telpon' => 628967567543,
        ]);

        $user = User::create([
            'name' => 'Citra ',
            'email' => 'citra@example.com',
            'password' => Hash::make("citraweb"),
            'role' => 'HRD',
            'nik' => 1231234,
            'no_telpon' => 628967567543,
        ]);

        $user = User::create([
            'name' => 'Rudhy',
            'email' => 'rudhy@example.com',
            'password' => Hash::make("rudhyweb"),
            'role' => 'Leader',
            'nik' => 1231234,
            'no_telpon' => 628967567543,
        ]);
        

        $user = Karyawan::create([
            'user_id' => '1',
            'jumlah_cuti' => 23,
            'divisi' => 'Akuntan',
            'jabatan' => 'Akuntan',
        ]);
        
        $user = Karyawan::create([
            'user_id' => '2',
            'jumlah_cuti' => 15,
            'divisi' => 'Akuntan',
            'jabatan' => 'Akuntan',
        ]);
        
        $user = Karyawan::create([
            'user_id' => '3',
            'jumlah_cuti' => 35,
            'divisi' => 'Akuntan',
            'jabatan' => 'Akuntan',
        ]);

        $user = Karyawan::create([
            'user_id' => '4',
            'jumlah_cuti' => 35,
            'divisi' => 'Akuntan',
            'jabatan' => 'Akuntan',
        ]);

        $user = Karyawan::create([
            'user_id' => '5',
            'jumlah_cuti' => 35,
            'divisi' => 'Akuntan',
            'jabatan' => 'Akuntan',
        ]);

        $user = Karyawan::create([
            'user_id' => '5',
            'jumlah_cuti' => 35,
            'divisi' => 'Akuntan',
            'jabatan' => 'Akuntan',
        ]);

        $user = Karyawan::create([
            'user_id' => '6',
            'jumlah_cuti' => 35,
            'divisi' => 'Divisi Support',
            'jabatan' => 'HRD',
        ]);

        // Super Admin

        
    }
}