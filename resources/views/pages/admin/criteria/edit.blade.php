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
                Form Ubah Data Criteria
            </div>
            <div class="card-body">
                <form action="{{ route('criteria.update', $criteria->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="name">Nama Criteria</label>
                        <input type="name" class="form-control" name="criteria_name" placeholder="Ubah nama criteria"
                            value="{{ $criteria->criteria_name }}">
                    </div>
                    <div class="form-group">
                        <label for="name">Pekerjaan</label>
                        <select name="job_type_id" id="" class="form-control">
                            <option value="#" class="text-muted">pilih tipe pekerjaan</option>
                            <option value="{{ $criteria->job_type->id }}" selected>{{ $criteria->job_type->job_name }}
                            </option>
                            @foreach ($jobs as $job)
                                <option value="{{ $job->id }}">{{ $job->job_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" href="#" class="btn btn-success btn-icon-split btn-block">
                        <span class="text">Ubah Data Criteria</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
