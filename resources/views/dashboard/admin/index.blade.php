@extends('dashboard.layouts.dashboard')
@section('dashboard-content')
    <div class="row">
        <div class="col-sm-6">
            <div class="card border-0 shadow" style="background: #fff;">
                <div class="card-body">
                    <h1>Jumlah Mahasiswa {{count($user)}}</h1>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card border-0 shadow" style="background: #fff;">
                <div class="card-body">
                    <h1>Mahasiswa yang sudah mengisi biodata {{count($biodata)}}</h1>
                </div>
            </div>
        </div>
    </div>
@endsection
