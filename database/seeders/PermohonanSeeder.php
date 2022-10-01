<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permohonan_Cuti;



class PermohonanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $permohonan = Permohonan_Cuti::create([
            'user_id' => '10',
            'alasan_cuti' => 'Istri Melahirkan',
            'tgl_mulai' => '2022-10-12',
            'tgl_akhir' => '2022-10-15',
            'tgl_memohon' => '2022-09-14',
            'durasi_cuti' => '4',
            'status' => 'Diatasan',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'warna_cuti' => '#6900c7'
        ]);

        $permohonan = Permohonan_Cuti::create([
            'user_id' => '9',
            'alasan_cuti' => 'Acara Pernikahan',
            'tgl_mulai' => '2022-10-17',
            'tgl_akhir' => '2022-10-20',
            'tgl_memohon' => '2022-09-14',
            'durasi_cuti' => '4',
            'status' => 'Diproses',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'warna_cuti' => '#929090'
        ]);


        $permohonan = Permohonan_Cuti::create([
            'user_id' => '4',
            'alasan_cuti' => 'Mau Healing Nih',
            'tgl_mulai' => '2022-10-12',
            'tgl_akhir' => '2022-10-15',
            'tgl_memohon' => '2022-09-14',
            'durasi_cuti' => '4',
            'status' => 'Dibatalkan',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $permohonan = Permohonan_Cuti::create([
            'user_id' => '6',
            'alasan_cuti' => 'Orang Tua Sakit',
            'tgl_mulai' => '2022-10-17',
            'tgl_akhir' => '2022-10-20',
            'tgl_memohon' => '2022-09-14',
            'durasi_cuti' => '4',
            'status' => 'Diatasan',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'warna_cuti' => '#6900c7'
        ]);

        $permohonan = Permohonan_Cuti::create([
            'user_id' => '5',
            'alasan_cuti' => 'Pemakamana nenek di Toraja',
            'tgl_mulai' => '2022-10-25',
            'tgl_akhir' => '2022-10-28',
            'tgl_memohon' => '2022-09-14',
            'durasi_cuti' => '4',
            'status' => 'Diterima',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'warna_cuti' => '#00ac69'
        ]);

        $permohonan = Permohonan_Cuti::create([
            'user_id' => '1',
            'alasan_cuti' => 'Mau liburan',
            'tgl_mulai' => '2022-10-12',
            'tgl_akhir' => '2022-10-15',
            'tgl_memohon' => '2022-09-14',
            'durasi_cuti' => '4',
            'ket_tolak' => 'Tidak dapat disetujui karena di tanggal itu ada pekerjaan urgent',
            'status' => 'Ditolak',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $permohonan = Permohonan_Cuti::create([
            'user_id' => '1',
            'alasan_cuti' => 'Kyaknya saya mau sakit',
            'tgl_mulai' => '2022-10-24',
            'tgl_akhir' => '2022-10-27',
            'tgl_memohon' => '2022-09-14',
            'durasi_cuti' => '4',
            'ket_tolak' => 'Tidak dapat disetujui karena di tanggal itu ada pekerjaan urgent',
            'status' => 'Diterima',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'warna_cuti' => '#00ac69'
        ]);
    }
}
