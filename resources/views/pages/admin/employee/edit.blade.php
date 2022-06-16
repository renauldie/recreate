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
                <form action="{{ route('employee.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="name">NIK</label>
                        <input type="name" class="form-control" name="nik" placeholder="Masukkan nama pekerjaan"
                            value="{{ $employee->nik }}">
                    </div>
                    <div class="form-group">
                        <label for="name">Nama Karyawan</label>
                        <input type="name" class="form-control" name="name" placeholder="Masukkan nama pekerjaan"
                            value="{{ $employee->name }}">
                    </div>
                    <div class="form-group">
                        <label for="name">Jenis Kelamin</label>
                        <select name="gender" id="" class="form-control">
                            @if ($employee->gender == 'male')
                                <option value="{{ $employee->gender }}">Pria</option>
                                <option value="female">Wanita</option>
                            @elseif($employee->gender == 'female')
                                <option value="{{ $employee->gender }}">Wanita</option>
                                <option value="male">Pria</option>
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Alamat</label>
                        <input type="name" class="form-control" name="address" placeholder="Masukkan nama pekerjaan"
                            value="{{ $employee->address }}">
                    </div>
                    <div class="form-group">
                        <label for="name">Tanggal Lahir</label>
                        <input type="name" class="form-control" name="date_of_birth" placeholder="Masukkan nama pekerjaan"
                            value="{{ $employee->date_of_birth }}">
                    </div>
                    <div class="form-group">
                        <label for="name">Kontak</label>
                        <input type="name" class="form-control" name="phone_number" placeholder="Masukkan nama pekerjaan"
                            value="{{ $employee->phone_number }}">
                    </div>
                    <div class="form-group">
                        <label for="name">Pekerjaan</label>
                        <select name="job_type_id" id="" class="form-control">
                            <option value="{{ $employee->job_type->id }}" class="text-muted">
                                {{ $employee->job_type->job_name }} (Berlaku)</option>
                            @foreach ($jobs as $job)
                                @if ($job->id != $employee->job_type->id)
                                    <option value="{{ $job->id }}">{{ $job->job_name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Status</label>
                        <select name="status" id="" class="form-control">
                            @if ($employee->status == 'active')
                                <option value="{{ $employee->status }}">Aktif</option>
                                <option value="deactive">Non Aktif</option>
                            @elseif($employee->status == 'deactive')
                                <option value="{{ $employee->status }}">Non Aktif</option>
                                <option value="active">Aktif</option>
                            @endif
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="image">Foto Karyawan</label>
                        <input type="file" class="form-control" name="image" placeholder="Image" >
                    </div>

                    <button type="submit" href="#" class="btn btn-success btn-icon-split btn-block">
                        <span class="text">Ubah Data Karyawan</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
