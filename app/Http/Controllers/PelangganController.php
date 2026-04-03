<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index()
    {
        return Pelanggan::with(['paket', 'kabupaten', 'kecamatan', 'desa', 'sales'])->latest()->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_pelanggan' => 'required|string|unique:pelanggans,id_pelanggan',
            'tanggal_daftar' => 'required|date',
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|size:16|unique:pelanggans,nik',
            'no_hp' => 'required|string',
            'email' => 'nullable|email',
            'kabupaten_id' => 'required|exists:kabupatens,id',
            'kecamatan_id' => 'required|exists:kecamatans,id',
            'desa_id' => 'required|exists:desas,id',
            'alamat_lengkap' => 'required|string',
            'status_langganan' => 'required|in:aktif,nonaktif,isolir',
            'paket_id' => 'required|exists:pakets,id',
            'sales_id' => 'nullable|exists:sales,id',
        ]);

        return Pelanggan::create($validated);
    }

    public function show(string $id)
    {
        return Pelanggan::with(['paket', 'kabupaten', 'kecamatan', 'desa', 'sales'])->findOrFail($id);
    }

    public function update(Request $request, string $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        
        $validated = $request->validate([
            'id_pelanggan' => 'sometimes|required|string|unique:pelanggans,id_pelanggan,'.$id,
            'tanggal_daftar' => 'sometimes|required|date',
            'nama' => 'sometimes|required|string|max:255',
            'nik' => 'sometimes|required|string|size:16|unique:pelanggans,nik,'.$id,
            'no_hp' => 'sometimes|required|string',
            'email' => 'nullable|email',
            'kabupaten_id' => 'sometimes|required|exists:kabupatens,id',
            'kecamatan_id' => 'sometimes|required|exists:kecamatans,id',
            'desa_id' => 'sometimes|required|exists:desas,id',
            'alamat_lengkap' => 'sometimes|required|string',
            'status_langganan' => 'sometimes|required|in:aktif,nonaktif,isolir',
            'paket_id' => 'sometimes|required|exists:pakets,id',
            'sales_id' => 'nullable|exists:sales,id',
        ]);

        $pelanggan->update($validated);
        return $pelanggan;
    }

    public function destroy(string $id)
    {
        Pelanggan::findOrFail($id)->delete();
        return response()->noContent();
    }
}
