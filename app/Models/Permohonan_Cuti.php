<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Permohonan_Cuti extends Model
{
    use HasFactory;
    protected $table = 'permohonan_cuti';

    protected $fillable = [
        'user_id',
        'alasan_cuti',
        'ket_tolak',
        'warna_cuti'
    ];

    protected $dates = [
        'tgl_mulai',
        'tgl_akhir',
    ];

    // public function userCuti()
    // {
    //     return $this->belongsTo(User::class);
    // }

}
