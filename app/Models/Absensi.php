<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function ortu()
    {
        return $this->belongsTo(OrangTua::class, 'ortu_id');
    }

    public function eskul()
    {
        return $this->belongsTo(Eskul::class, 'eskul_id');
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
