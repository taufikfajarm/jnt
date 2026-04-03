<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Default Admin User
        \App\Models\User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Administrator',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
            ]
        );

        // Packages
        \App\Models\Paket::create(['nama_paket' => 'Home Basic', 'kecepatan' => '20 Mbps', 'harga' => 150000]);
        \App\Models\Paket::create(['nama_paket' => 'Home Plus', 'kecepatan' => '50 Mbps', 'harga' => 250000]);
        \App\Models\Paket::create(['nama_paket' => 'Home Ultra', 'kecepatan' => '100 Mbps', 'harga' => 450000]);

        // Regions Sample
        $kab = \App\Models\Kabupaten::create(['nama' => 'Banyuwangi']);
        
        $kec1 = $kab->kecamatans()->create(['nama' => 'Banyuwangi']);
        $kec2 = $kab->kecamatans()->create(['nama' => 'Giri']);
        
        $kec1->desas()->create(['nama' => 'Kepatihan']);
        $kec1->desas()->create(['nama' => 'Penganjuran']);
        
        $kec2->desas()->create(['nama' => 'Mojopanggung']);
        $kec2->desas()->create(['nama' => 'Penataban']);
    }
}
