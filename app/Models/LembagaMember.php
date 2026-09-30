<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LembagaMember extends Model
{
    use HasFactory;

    protected $table = 'institution_members';

    protected $fillable = [
        'lembaga_id',
        'nama',
        'jabatan',
        'pendidikan',
        'urutan',
    ];

    public function lembaga()
    {
        return $this->belongsTo(Lembaga::class, 'lembaga_id');
    }
}
