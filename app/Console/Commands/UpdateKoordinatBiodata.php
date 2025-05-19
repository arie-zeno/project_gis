<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Biodata;
use App\Models\AlamatCache;

class UpdateKoordinatBiodata extends Command
{
    protected $signature = 'biodata:update-koordinat';
    protected $description = 'Mengisi koordinat secara otomatis untuk biodata yang belum memiliki koordinat';

    public function handle()
    {
        $biodatas = Biodata::whereNull('koordinat')->get();
        $this->info("Memproses {$biodatas->count()} biodata...");

        foreach ($biodatas as $biodata) {
            $kabupaten = in_array(strtolower($biodata->kabupaten), ['banjarmasin', 'banjarbaru']) 
                ? "Kota {$biodata->kabupaten}" 
                : "Kabupaten {$biodata->kabupaten}";

            // Alamat lengkap
            $alamatLengkap = "{$biodata->alamat}, {$biodata->kelurahan}, {$biodata->kecamatan}, {$kabupaten}, {$biodata->provinsi}, Indonesia";

            // Alamat fallback tanpa jalan
            $alamatFallback = "{$biodata->kelurahan}, {$biodata->kecamatan}, {$kabupaten}, {$biodata->provinsi}, Indonesia";

            // Coba koordinat dengan alamat lengkap
            if ($this->prosesAlamat($biodata, $alamatLengkap)) {
                continue;
            }

            // Jika gagal, coba dengan alamat fallback
            $this->warn("🔄 Mencoba ulang dengan alamat tanpa detail jalan untuk NIM {$biodata->nim}...");
            $this->prosesAlamat($biodata, $alamatFallback);
        }

        $this->info("Selesai memperbarui koordinat.");
    }

    private function prosesAlamat($biodata, $alamat)
    {
        // Cek cache
        $cache = AlamatCache::where('alamat', $alamat)->first();
        if ($cache) {
            $biodata->koordinat = $cache->koordinat;
            $biodata->save();
            $this->line("✅ Koordinat dari cache untuk NIM {$biodata->nim}");
            return true;
        }

        try {
            sleep(1); // Hindari rate limit
            $this->line("Alamat yang diproses: $alamat");

            $response = Http::timeout(10)
                ->withHeaders([
                    'User-Agent' => 'GISMahasiswaPILKOM/1.0 (alfikanurfadia@email.com)',
                ])
                ->get('https://nominatim.openstreetmap.org/search', [
                    'q' => $alamat,
                    'format' => 'json',
                    'limit' => 1,
                ]);

            $this->line("Response API:");
            $this->line(json_encode($response->json(), JSON_PRETTY_PRINT));
            $this->line("");

            if ($response->successful() && count($response->json()) > 0) {
                $data = $response->json()[0];
                $koordinat = "{$data['lat']},{$data['lon']}";

                // Simpan hasil
                $biodata->koordinat = $koordinat;
                $biodata->save();

                AlamatCache::create([
                    'alamat' => $alamat,
                    'koordinat' => $koordinat,
                ]);

                $this->line("✅ Koordinat berhasil untuk NIM {$biodata->nim}");
                return true;
            } else {
                $this->warn("⚠️  Tidak ditemukan koordinat untuk alamat: {$alamat}");
                return false;
            }
        } catch (\Exception $e) {
            $this->error("❌ Error untuk NIM {$biodata->nim}: {$e->getMessage()}");
            return false;
        }
    }
}
