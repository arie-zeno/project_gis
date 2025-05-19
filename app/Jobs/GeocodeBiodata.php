<?php
namespace App\Jobs;

use App\Models\Biodata;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeocodeBiodata implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 5;
    public $backoff = 10;

    protected $biodata;

    public function __construct(Biodata $biodata)
    {
        $this->biodata = $biodata;
    }

    public function handle()
    {
        // Susun alamat berdasarkan field yang tidak kosong
        $components = array_filter([
            $this->biodata->kelurahan,
            $this->biodata->kecamatan,
            $this->biodata->kabupaten,
            $this->biodata->provinsi,
            'Indonesia'
        ]);

        // Jika semua komponen kosong, tidak perlu lanjut
        if (count($components) <= 1) {
            Log::warning("Semua komponen alamat kosong untuk NIM {$this->biodata->nim}");
            return;
        }

        $address = implode(', ', $components);

        // Kirim request ke Nominatim
        $response = Http::withHeaders([
            'User-Agent' => 'GISMahasiswaPILKOM/1.0 (alfikanurfadia@gmail.com)'
        ])->get('https://nominatim.openstreetmap.org/search', [
            'q' => $address,
            'format' => 'json',
            'limit' => 1,
        ]);

        if ($response->successful() && count($response->json()) > 0) {
            $data = $response->json()[0];
            $lat = $data['lat'];
            $lon = $data['lon'];

            $this->biodata->koordinat = "$lat,$lon";
            $this->biodata->save();
        } else {
            Log::warning("Gagal geocode untuk NIM {$this->biodata->nim} | Alamat: $address");
            $this->release(10); // Retry 10 detik kemudian
        }
    }
}
