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
            'user_id' => '1',
            'alasan_cuti' => 'libur Akhir Tahun',
            'tgl_mulai' => '2022-10-01',
            'tgl_akhir' => '2022-10-03',
            'tgl_memohon' => '2022-09-03',
            'durasi_cuti' => '3',
            'status' => 'Baru'
        ]);
        
        $permohonan = Permohonan_Cuti::create([
            'user_id' => '2',
            'alasan_cuti' => 'Istri Melahirkan',
            'tgl_mulai' => '2022-10-20',
            'tgl_akhir' => '2022-10-25',
            'tgl_memohon' => '2022-09-10',
            'durasi_cuti' => '5',
            'status' => 'Diterima'
        ]);
        
        $permohonan = Permohonan_Cuti::create([
            'user_id' => '3',
            'alasan_cuti' => 'Istri Melahirkan',
            'tgl_mulai' => '2022-10-12',
            'tgl_akhir' => '2022-10-15',
            'tgl_memohon' => '2022-09-14',
            'durasi_cuti' => '3',
            'status' => 'Diatasan'
        ]);

        $permohonan = Permohonan_Cuti::create([
            'user_id' => '4',
            'alasan_cuti' => 'Minta izin pemakamana nenek di Toraja',
            'tgl_mulai' => '2022-10-12',
            'tgl_akhir' => '2022-10-15',
            'tgl_memohon' => '2022-09-14',
            'durasi_cuti' => '3',
            'status' => 'Batal'
        ]);

        $permohonan = Permohonan_Cuti::create([
            'user_id' => '5',
            'alasan_cuti' => 'Mau liburan nih guys, tolong setujui cuti saya yah, Thanks',
            'tgl_mulai' => '2022-10-12',
            'tgl_akhir' => '2022-10-15',
            'tgl_memohon' => '2022-09-14',
            'durasi_cuti' => '3',
            'ket_tolak' => 'Tidak dapat disetujui karena di tanggal itu ada pekerjaan urgent',
            'status' => 'Ditolak'
        ]);
    }
}
