@extends('layouts.draft')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="container">
                        <h2>Edit Profil</h2>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <form action="{{ route('profile.update') }}" method="post">
                            @csrf
                            @method('PUT')

                            <div class="form-group mb-3">
                                <label for="name">Nama:</label>
                                <input class="form-control" type="text" name="name" value="{{ $user->name }}"
                                    required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="email">Email:</label>
                                <input class="form-control" type="email" name="email" value="{{ $user->email }}"
                                    required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="password">Password Baru:</label>
                                <input class="form-control" type="password" name="password"
                                    placeholder="Kosongkan jika tidak ingin mengubah">
                            </div>
                            <div class="form-group mb-3">
                                <label for="password_confirmation">Konfirmasi Password:</label>
                                <input class="form-control" type="password" name="password_confirmation"
                                    placeholder="Kosongkan jika tidak ingin mengubah">
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
