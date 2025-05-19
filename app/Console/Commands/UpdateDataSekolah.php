<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Sekolah;
use App\Models\AlamatCache;

class UpdateDataSekolah extends Command
{
    protected $signature = 'sekolah:update-data';
    protected $description = 'Mengisi data wilayah dan koordinat berdasarkan nama sekolah';

    public function handle()
    {
        $sekolahs = Sekolah::whereNull('koordinat')->orWhereNull('provinsi')->get();
        $this->info("Memproses {$sekolahs->count()} sekolah...");

        foreach ($sekolahs as $sekolah) {
            $alamat = "{$sekolah->nama_sekolah}, Indonesia";
            $this->line("🔍 Mencari data untuk: {$sekolah->nama_sekolah}");

            // Cek di cache
            $cache = AlamatCache::where('alamat', $alamat)->first();
            if ($cache) {
                $this->isiDataSekolah($sekolah, $cache->koordinat, $cache->detail);
                $this->line("✅ Data dari cache");
                continue;
            }

            try {
                sleep(1); // Hindari rate limit

                $response = Http::timeout(10)
                    ->withHeaders([
                        'User-Agent' => 'GISMahasiswaPILKOM/1.0 (alfikanurfadia@email.com)',
                    ])
                    ->get('https://nominatim.openstreetmap.org/search', [
                        'q' => $alamat,
                        'format' => 'json',
                        'limit' => 1,
                        'addressdetails' => 1,
                    ]);

                if ($response->successful() && count($response->json()) > 0) {
                    $data = $response->json()[0];
                    $koordinat = "{$data['lat']},{$data['lon']}";
                    $address = $data['address'];

                    // Simpan hasil
                    $this->isiDataSekolah($sekolah, $koordinat, $address);

                    // Cache hasil
                    AlamatCache::create([
                        'alamat' => $alamat,
                        'koordinat' => $koordinat,
                        'detail' => json_encode($address),
                    ]);

                    $this->info("✅ Data berhasil disimpan untuk {$sekolah->nama_sekolah}");
                } else {
                    $this->warn("⚠️  Tidak ditemukan data untuk: {$alamat}");
                }
            } catch (\Exception $e) {
                $this->error("❌ Error: {$e->getMessage()}");
            }
        }

        $this->info("Selesai memperbarui data sekolah.");
    }

    private function isiDataSekolah($sekolah, $koordinat, $address)
    {
        $sekolah->koordinat = $koordinat;
        $sekolah->provinsi = 
            $address['state'] ?? 
            null;
        $sekolah->kabupaten = 
            $address['county'] ??
            $address['city'] ??
            $address['town'] ??
            null;
        $sekolah->kecamatan =
            $address['suburb'] ??
            $address['city_district'] ?? 
            $address['village'] ?? 
            null;
        $sekolah->kelurahan = 
            $address['village'] ??
            $address['suburb'] ?? 
            $address['neighbourhood'] ??         
            null;
        $sekolah->save();
    }
}
