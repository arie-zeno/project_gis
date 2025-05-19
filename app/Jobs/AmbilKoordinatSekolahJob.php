<?php

namespace App\Jobs;

use App\Models\Sekolah;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class AmbilKoordinatSekolahJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $sekolah;

    /**
     * Create a new job instance.
     */
    public function __construct(Sekolah $sekolah)
    {
        $this->sekolah = $sekolah;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            sleep(1); // Hindari rate-limit

            $response = Http::timeout(10)
                ->withHeaders([
                    'User-Agent' => 'GISMahasiswaPILKOM/1.0 (alfikanurfadia@gmail.com)',
                ])
                ->get('https://nominatim.openstreetmap.org/search', [
                    'q' => $this->sekolah->nama_sekolah . ', Indonesia',
                    'format' => 'json',
                    'limit' => 1,
                    'addressdetails' => 1,
                ]);

            if ($response->successful() && !empty($response[0])) {
                $address = $response[0]['address'];

                $this->sekolah->update([
                    'provinsi' => $address['state'] ?? null,
                    'kabupaten' => $address['county'] 
                                ?? $address['city'] 
                                ?? $address['town'] 
                                ?? null,
                    'kecamatan' => $address['suburb'] 
                                ?? $address['city_district'] 
                                ?? $address['village'] 
                                ?? null,
                    'kelurahan' => $address['village'] 
                                ?? $address['suburb'] 
                                ?? $address['neighbourhood'] 
                                ?? null,
                    'koordinat' => "{$response[0]['lat']},{$response[0]['lon']}",
                ]);
            }
        } catch (\Exception $e) {
            $this->fail($e); // otomatis retry kalau pakai queue
        }
    }
}
