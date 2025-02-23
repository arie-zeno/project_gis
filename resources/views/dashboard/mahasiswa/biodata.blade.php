{{-- @dd($biodata) --}}
@extends('dashboard.layouts.dashboard')

@section('dashboard-content')
    @if ($biodata != null)
        <div class="card border-0 shadow" style="background: #fff;">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-2">
                        <img src="{{ $biodata->foto ? asset('storage/'.$biodata->foto) : asset('img/il_1.svg') }}" class="img-fluid rounded shadow" alt="..." style="max-height: 300px">
                    </div>
                    <div class="col-sm-4 d-flex flex-column justify-content-center">
                        <h2 class="fw-light">{{$biodata->nama}}</h2>
                        <h5 class="fw-light mb-4">{{ $biodata->nim }} </h5>
                        <table>
                            <tr>
                                <td class="fw-bold" style="width: 200px">Angkatan</td>
                                <td style="width: 300px">{{ $biodata->angkatan }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold" style="width: 200px">Provinsi</td>
                                <td style="width: 300px">{{ $biodata->provinsi }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold" style="width: 200px">Kabupaten/Kota</td>
                                <td style="width: 300px">{{ $biodata->kabupaten }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold" style="width: 200px">Kecamatan</td>
                                <td style="width: 300px">{{ $biodata->kecamatan }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold" style="width: 200px">Kelurahan</td>
                                <td style="width: 300px">{{ $biodata->kelurahan }}</td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>

        </div>
    @else
        <div class="card border-0 shadow" style="background: #fff;">
            <div class="card-body">
                <h2>Anda belum mengisi biodata, <a href="{{ route('isi.biodata') }}">isi biodata</a></h2>
            </div>
        </div>
    @endif
@endsection
