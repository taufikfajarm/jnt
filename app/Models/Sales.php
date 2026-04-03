<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $fillable = [
        'nama',
        'no_hp',
        'alamat',
        'status',
    ];

    public function pelanggans()
    {
        return $this->hasMany(Pelanggan::class);
    }
}
