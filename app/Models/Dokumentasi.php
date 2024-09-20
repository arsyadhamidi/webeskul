<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumentasi extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function eskul()
    {
        return $this->belongsTo(Eskul::class, 'eskul_id');
    }

    public function pembina()
    {
        return $this->belongsTo(Pembina::class, 'pembina_id');
    }
}
