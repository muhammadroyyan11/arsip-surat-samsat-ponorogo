<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKeluar extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function kategori() { return $this->belongsTo(KategoriSurat::class, 'kategori_id'); }
    public function user() { return $this->belongsTo(User::class); }
}
