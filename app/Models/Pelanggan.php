<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $fillable = [
        'id_pelanggan',
        'tanggal_daftar',
        'nama',
        'nik',
        'no_hp',
        'email',
        'kabupaten_id',
        'kecamatan_id',
        'desa_id',
        'alamat_lengkap',
        'status_langganan',
        'paket_id',
        'sales_id',
    ];

    public function sales()
    {
        return $this->belongsTo(Sales::class);
    }

    public function paket()
    {
        return $this->belongsTo(Paket::class);
    }

    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class);
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }
}
