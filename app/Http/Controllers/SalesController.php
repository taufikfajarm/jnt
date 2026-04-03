<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index()
    {
        return Sales::latest()->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        return Sales::create($validated);
    }

    public function show(string $id)
    {
        return Sales::findOrFail($id);
    }

    public function update(Request $request, string $id)
    {
        $sales = Sales::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'sometimes|required|string|max:255',
            'no_hp' => 'sometimes|required|string|max:20',
            'alamat' => 'sometimes|required|string',
            'status' => 'sometimes|required|in:aktif,nonaktif',
        ]);

        $sales->update($validated);
        return $sales;
    }

    public function destroy(string $id)
    {
        Sales::findOrFail($id)->delete();
        return response()->noContent();
    }
}
