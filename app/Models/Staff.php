<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function division() { return $this->belongsTo(Division::class); }
    public function position() { return $this->belongsTo(Position::class); }
    public function user() { return $this->hasOne(User::class, 'staff_id'); }
}
