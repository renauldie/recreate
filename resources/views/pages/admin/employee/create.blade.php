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
    <div class="col-lg-10">
        <div class="card mb-4">
            <div class="card-header">
                Form Tambah Data karyawan
            </div>
            <div class="card-body">
                <form action="{{ route('employee.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">NIK</label>
                        <input type="name" class="form-control" name="nik" placeholder="Masukkan nama pekerjaan"
                            value="{{ old('nik') }}">
                    </div>
                    <div class="form-group">
                        <label for="name">Nama Karyawan</label>
                        <input type="name" class="form-control" name="name" placeholder="Masukkan nama pekerjaan"
                            value="{{ old('name') }}">
                    </div>
                    <div class="form-group">
                        <label for="name">Jenis Kelamin</label>
                        <input type="name" class="form-control" name="gender" placeholder="Masukkan nama pekerjaan"
                            value="{{ old('gender') }}">
                    </div>
                    <div class="form-group">
                        <label for="name">Alamat</label>
                        <input type="name" class="form-control" name="address" placeholder="Masukkan nama pekerjaan"
                            value="{{ old('address') }}">
                    </div>
                    <div class="form-group">
                        <label for="name">Tanggal Lahir</label>
                        <input type="name" class="form-control" name="date_of_birth" placeholder="Masukkan nama pekerjaan"
                            value="{{ old('date_of_birth') }}">
                    </div>
                    <div class="form-group">
                        <label for="name">Kontak</label>
                        <input type="name" class="form-control" name="phone_number" placeholder="Masukkan nama pekerjaan"
                            value="{{ old('phone_number') }}">
                    </div>
                    <div class="form-group">
                        <label for="name">Pekerjaan</label>
                        <select name="job_type_id" id="" class="form-control">
                            <option value="#" class="text-muted">pilih tipe pekerjaan</option>
                            @foreach ($jobs as $job)
                                <option value="{{ $job->id }}">{{ $job->job_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Status</label>
                        <select name="status" id="" class="form-control">
                            <option value="ACTIVE">Aktif</option>
                            <option value="DEACTIVE">Non Aktif</option>
                        </select>
                    </div>

                    <button type="submit" href="#" class="btn btn-success btn-icon-split btn-block">
                        <span class="text">Tambah Data Karyawan</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
