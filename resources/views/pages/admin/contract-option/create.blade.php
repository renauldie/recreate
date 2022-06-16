@extends('layouts.admin.admin')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="col-lg-7">
        <div class="card mb-4">
            <div class="card-header">
                Form Tambah Data Opsi Kontrak
            </div>
            <div class="card-body">
                <form action="{{ route('contract-option.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Presentase Ranking (dalam persen)</label>
                        <input type="name" class="form-control" name="rank_percentage" placeholder="Presentase Kontrak cth: 10"
                            value="{{ old('criteria_name') }}">
                        <small id="emailHelp" class="form-text text-muted">nilai tidak boleh lebih dari {{ $perc }}</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="name">Durasi Kontrak (dalam bulan)</label>
                        <input type="name" class="form-control" name="contract" placeholder="Durasi Kontrak cth: 5"
                            value="{{ old('criteria_name') }}">
                    </div>
                    <button type="submit" href="#" class="btn btn-success btn-icon-split btn-block">
                        <span class="text">Tambah Data Opsi Kontrak</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
