@extends('dashboard.layouts.dashboard')
@section('dashboard-content')
    <div class="row">

        <div class="col-sm-12">
            <div class="card border-0 shadow" style="background: #fff;">
                <div class="card-body">
                    <div id="toolbar">
                        <button class=" btn btn-sm  btn-outline-primary" type="button" data-bs-toggle="modal"
                            data-bs-target="#addModal"> <i class="bi bi-person-plus-fill"></i>
                            Tambah Mahasiswa</button>
                        
                        <button class=" btn btn-sm  btn-outline-success" type="button" data-bs-toggle="modal"
                            data-bs-target="#importModal"> <i class="bi bi-file-earmark-excel-fill"></i>
                            Import Mahasiswa</button>

                        <button class=" btn btn-sm  btn-outline-success" type="button" data-bs-toggle="modal"
                            data-bs-target="#importBiodata"> <i class="bi bi-file-person-fill"></i>
                            Import Biodata</button>

                        <button id="exportButton" class="  btn btn-sm  btn-outline-danger" type="button"> <i
                                class="bi bi-file-earmark-excel-fill"></i>
                            Export Data</button>

                        <!-- Tambahkan dua iframe tersembunyi -->
                        <iframe id="iframeExport1" style="display: none;"></iframe>
                        <iframe id="iframeExport2" style="display: none;"></iframe>

                    </div>

                    <table data-toggle="table" data-search="true" data-searchable="true" data-pagination="true"  data-toolbar="#toolbar">
                        <thead>
                            <tr class="text-center">
                                <th>Nama</th>
                                <th>NIM</th>
                                <th>Status</th>
                                <th>Biodata</th>
                                <th>Riwayat Pendidikan</th>
                                <th>Operasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user as $item)
                                <tr>
                                    <td>{{ Str::title($item->name) }}</td>
                                    <td class="text-center">{{ $item->nim }}</td>
                                    @if ($item->biodata)
                                    <td class="text-center">{{ $item->biodata["status"] }}</td>
                                    @else
                                    <td class="text-center"> <i class="bi bi-x-circle-fill text-danger"></i>
                                    @endif
                                    <td class="text-center"><i
                                            class="bi {{ $item->biodata ? 'bi-check-circle-fill text-success' : 'bi-x-circle-fill text-danger' }} "></i>
                                    </td>
                                    <td class="text-center">
                                        @if ($item->biodata)
                                            <i
                                                class="bi {{ $item->biodata->id_sekolah != null ? 'bi-check-circle-fill text-success' : 'bi-x-circle-fill text-danger' }} "></i>
                                        @else
                                            <i class="bi bi-x-circle-fill text-danger"></i>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('lihat.mahasiswa', $item->nim) }}"
                                            class="btn btn-sm btn-outline-primary">Lihat</a>

                                        <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal"
                                            data-bs-target="#statusModal">Ubah Status</button>

                                        <a href="{{ route('hapus.mahasiswa', $item->nim) }}" data-confirm-delete="true"
                                            class="btn btn-sm btn-outline-danger btn-hapus">Hapus</a>
                                    </td>

                                    <!-- Modal ganti password -->
                                    <div class="modal fade" id="statusModal" tabindex="-1"
                                        aria-labelledby="statusModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="statusModalLabel">Ganti status</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('ganti.status', $item->nim) }}" method="POST">
                                                        @csrf
                                                        <select name="status" class="form-select" aria-label="Default select example">
                                                            <option value="Aktif">Aktif</option>
                                                            <option value="Lulus">Lulus</option>
                                                        </select>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary"
                                                        data-bs-dismiss="modal">Tutup</button>
                                                    <button type="submit"
                                                        class="btn btn-sm btn-outline-primary">Simpan</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </tr>
                            @endforeach
                        </tbody>
                        <!-- Tampilkan pagination -->
                    </table>


                </div>
                <div class="px-4">

                    {{-- {{ $user->links('pagination::bootstrap-5') }} --}}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah User -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addModalLabel">Tambah User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('store.mahasiswa') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nim" class="form-label">NIM</label>
                            <input type="text" class="form-control" id="nim"
                                placeholder="Contoh : 2110100000000" name="nim">
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" placeholder="Contoh : Budi"
                                name="nama">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-outline-secondary"
                        data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-sm btn-outline-primary">Tambah</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Import User -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="importModalLabel">Import User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('import.users') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupFile01">Upload File</label>
                            <input type="file" class="form-control" id="inputGroupFile01" name="file">
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-outline-secondary"
                        data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-sm btn-outline-primary">Import</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Import Biodata -->
    <div class="modal fade" id="importBiodata" tabindex="-1" aria-labelledby="importBiodataLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="importBiodataLabel">Import Biodata</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('import.biodata') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupFile01">Upload File</label>
                            <input type="file" class="form-control" id="inputGroupFile01" name="file">
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-outline-secondary"
                        data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-sm btn-outline-primary">Import</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <script>
        function buttons() {
            return {
                btnUsersAdd: {
                    text: 'Highlight Users',
                    icon: 'bi-arrow-down',
                    event: function() {
                        alert('Do some stuff to e.g. search all users which has logged in the last week')
                    },
                    attributes: {
                        title: 'Search all users which has logged in the last week'
                    }
                },
                btnAdd: {
                    text: 'Add new row',
                    icon: 'bi-arrow-clockwise',
                    event: function() {
                        alert('Do some stuff to e.g. add a new row')
                    },
                    attributes: {
                        title: 'Add a new row to the table'
                    }
                }
            }

        }
    </script>

    <script>
        document.getElementById("exportButton").addEventListener("click", function() {
            // Menggunakan iframe agar browser tidak memblokir multiple downloads
            document.getElementById("iframeExport1").src = "{{ route('export.users') }}";
            document.getElementById("iframeExport2").src = "{{ route('export.biodata') }}";
        });
    </script>
@endsection