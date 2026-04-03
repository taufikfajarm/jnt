<?php

namespace App\Http\Controllers;

use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Desa;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function kabupatens()
    {
        return Kabupaten::all();
    }

    public function kecamatans($kabupatenId)
    {
        return Kecamatan::where('kabupaten_id', $kabupatenId)->get();
    }

    public function desas($kecamatanId)
    {
        return Desa::where('kecamatan_id', $kecamatanId)->get();
    }
}
