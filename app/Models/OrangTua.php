<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrangTua extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function users()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
}
