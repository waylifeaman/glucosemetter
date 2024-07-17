@extends('layouts.draft')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row justify-content-between align-items-center">
                            <div class="col">

                                <h3 class="card-title">Pilih Admin
                                </h3>
                            </div>
                            <div class="col-auto">
                                <input type="text" id="searchInput" class="form-control" placeholder="Search....">
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        {{-- <a class="btn btn-primary text-white text-decoration-none mb-4"
                            href="{{ route('pengguna.create') }}">tambah
                            pengguna</a> --}}
                        <table class="table table-striped text-center" id="dataTable">
                            <tr>
                                <th>Id</th>
                                <th>Nama</th>
                                <th class="d-none d-md-table-cell">Email</th>
                                <th class="d-none d-md-table-cell">Dibuat</th>
                                {{-- <th>Aksi</th> --}}
                            </tr>
                            @foreach ($user as $user)
                                <tr>
                                    <td>{{ $i++ }} <a href=""></a></td>
                                    <td>{{ $user->name }}</td>
                                    <td class="d-none d-md-table-cell">{{ $user->email }}</td>
                                    <td class="d-none d-md-table-cell">{{ $user->created_at }}</td>
                                    {{-- <td>
                                        <a href="{{ route('penyakit.show', $user->id) }}"
                                            class="btn btn-primary btn-sm">Pilih</a>
                                    </td> --}}

                                    {{-- <td><a href="{{ route('profile.form', $user->id) }}"
                                            class="btn btn-primary btn-sm">Edit</a>
                                        <form action="{{ route('pengguna.destroy', $user->id) }}" method="POST"
                                            style="display:inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Apakah Anda Yakin Ingin Menghapus Data ? ')">Delete</button>
                                        </form>
                                    </td> --}}
                                </tr>
                            @endforeach
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const dataTable = document.getElementById('dataTable');
            const rows = dataTable.getElementsByTagName('tr');

            searchInput.addEventListener('keyup', function(event) {
                const searchText = event.target.value.toLowerCase();

                for (let row of rows) {
                    const cells = row.getElementsByTagName('td');
                    let found = false;

                    for (let cell of cells) {
                        if (cell.textContent.toLowerCase().includes(searchText)) {
                            found = true;
                            break;
                        }
                    }

                    if (found) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            });
        });
    </script>
@endsection
