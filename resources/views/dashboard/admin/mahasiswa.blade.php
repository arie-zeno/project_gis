@extends('dashboard.layouts.dashboard')
@section('dashboard-content')
    <div class="row">

        <div class="col-sm-12">
            <div class="card border-0 shadow" style="background: #fff;">
                <div class="card-body">
                    <div id="toolbar">
                        <button class=" btn btn-sm  btn-success"> Import</button></h4>
                    </div>

                    <table data-toggle="table" data-search="true" data-toolbar="#toolbar" >
                        <thead>
                            <tr class="text-center">
                                <th>Nama</th>
                                <th>E-Mail</th>
                                <th>Angkatan</th>
                                <th>Operasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user as $item)
                                <tr>
                                    <td>{{ $item->biodata->nama }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->biodata->angkatan }}</td>
                                    <td class="text-center"><button class="btn btn-sm btn-danger">Hapus</button></td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>

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
@endsection
