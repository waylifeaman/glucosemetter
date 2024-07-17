@extends('layouts.draft')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row justify-content-between align-items-center">
                            <div class="col">
                                <h3 class="card-title">Pilih Pengguna</h3>
                            </div>
                            <div class="col-auto">
                                <input type="text" id="searchInput" class="form-control" placeholder="Search....">
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <a class="btn btn-primary text-white text-decoration-none mb-4"
                            href="{{ route('pasien.create') }}">Tambah Pengguna</a>
                        <table class="table table-striped text-center" id="pasienTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Usia</th>
                                    <th class="d-none d-md-table-cell">No Tlp</th>
                                    <th class="d-none d-md-table-cell">Alamat</th>
                                    <th class="d-none d-md-table-cell">Dibuat</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pasien as $p)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $p->name }}</td>
                                        <td>{{ $p->age }}</td>
                                        <td class="d-none d-md-table-cell">{{ $p->phone }}</td>
                                        <td class="d-none d-md-table-cell">{{ $p->alamat }}</td>
                                        <td class="d-none d-md-table-cell">{{ $p->created_at }}</td>
                                        <td class="">
                                            <a href="{{ route('penyakit.show', ['id' => $p->id]) }}"
                                                class="btn btn-primary btn-sm btn-select"
                                                data-id="{{ $p->id }}">Pilih</a>
                                            <a href="{{ route('pasien.show', ['id' => $p->id]) }}"
                                                class="btn btn-warning btn-sm">Edit</a> <!-- Tombol untuk edit -->
                                            <form action="{{ route('pasien.destroy', ['id' => $p->id]) }}" method="POST"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
                                                <!-- Tombol untuk delete -->
                                            </form>
                                        </td>
                                        {{-- <td>
                                            <a href="{{ route('penyakit.show', ['id' => $p->id]) }}"
                                                class="btn btn-primary btn-sm btn-select"
                                                data-id="{{ $p->id }}">Pilih</a>
                                        </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="inputModal" tabindex="-1" role="dialog" aria-labelledby="inputModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="inputModalLabel">Inputkan Id Pengguna Terlebih Dahulu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="inputForm">
                        @csrf
                        <div class="form-group">
                            <label for="value">Input Id</label>
                            <input type="number" class="form-control" id="value" name="value" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" required readonly>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnSelects = document.querySelectorAll('.btn-select');
            const inputModal = $('#inputModal');
            const inputForm = document.getElementById('inputForm');
            let selectedLink;

            btnSelects.forEach(btn => {
                btn.addEventListener('click', function(event) {
                    event.preventDefault();
                    const id = btn.getAttribute('data-id');
                    document.getElementById('value').value = id;

                    // Ambil nama pasien dari kolom kedua di tabel (asumsi kolom kedua adalah nama)
                    const row = btn.closest('tr');
                    const name = row.querySelector('td:nth-child(2)').textContent;
                    document.getElementById('name').value = name;

                    selectedLink = btn.getAttribute('href');
                    inputModal.modal('show');
                });
            });

            inputForm.addEventListener('submit', function(event) {
                event.preventDefault();
                const value = document.getElementById('value').value;
                const name = document.getElementById('name').value;

                if (value && name) {
                    const formData = new FormData(inputForm);
                    fetch('/send-data', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .content,
                            },
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.error) {
                                alert('Error: ' + data.error);
                            } else {
                                alert('Data successfully sent to ESP8266.');
                                inputModal.modal('hide');
                                window.location.href = selectedLink;
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                }
            });

            // Search function
            const searchInput = document.getElementById('searchInput');
            searchInput.addEventListener('input', function() {
                const filter = searchInput.value.toLowerCase();
                const rows = document.querySelectorAll('#pasienTable tbody tr');

                rows.forEach(row => {
                    const cells = row.querySelectorAll('td');
                    let match = false;

                    cells.forEach(cell => {
                        if (cell.textContent.toLowerCase().includes(filter)) {
                            match = true;
                        }
                    });

                    if (match) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    </script>
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnSelects = document.querySelectorAll('.btn-select');
            const inputModal = $('#inputModal');
            const inputForm = document.getElementById('inputForm');
            let selectedLink;

            btnSelects.forEach(btn => {
                btn.addEventListener('click', function(event) {
                    event.preventDefault();
                    const id = btn.getAttribute('data-id');
                    document.getElementById('value').value = id;
                    selectedLink = btn.getAttribute('href'); // Tambahkan
                    inputModal.modal('show');
                });
            });

            inputForm.addEventListener('submit', function(event) {
                event.preventDefault();
                const value = document.getElementById('value').value;

                if (value) {
                    const formData = new FormData(inputForm);
                    fetch('/send-data', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .content,
                            },
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.error) {
                                alert('Error: ' + data.error);
                            } else {
                                alert('Data successfully sent to ESP8266.');
                                inputModal.modal('hide');
                                window.location.href = selectedLink;
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                }
            });

            // Search function
            const searchInput = document.getElementById('searchInput');
            searchInput.addEventListener('input', function() {
                const filter = searchInput.value.toLowerCase();
                const rows = document.querySelectorAll('#pasienTable tbody tr');

                rows.forEach(row => {
                    const cells = row.querySelectorAll('td');
                    let match = false;

                    cells.forEach(cell => {
                        if (cell.textContent.toLowerCase().includes(filter)) {
                            match = true;
                        }
                    });

                    if (match) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    </script> --}}
@endsection
