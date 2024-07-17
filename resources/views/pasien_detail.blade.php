@extends('layouts.draft')


@section('content')
    <div class="row justify-content-center">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h3>Hallo {{ $pasien->name }}</h3>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
