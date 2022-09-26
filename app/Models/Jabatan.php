<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;
    protected $table = 'jabatan';

    protected $fillable = [
        'nama_jabatan',
        'id_divisi'
    ];

    // public function divisi()
    // {
    //     return $this->belongsTo(Divisi::class);
    // }
}
