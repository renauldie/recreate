@extends('layouts.admin.admin')

@push('addon-style')
    <link href="{{ url('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Data Hasil Perhitungan Tipe Pekerjaan</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-2 col-md-7">
            <div class="card-header py-3">
                <div class="d-sm-flex align-items-center justify-content-between mb-2">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Data Tipe Pekerjaan
                    </h6>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pekerjaan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Nama Pekerjaan</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @php
                                $n = 1;
                            @endphp
                            @foreach ($items as $item)
                            <tr>
                                <td>{{ $n++ }}</td>
                                <td>{{ $item->job_name }}</td>
                                <td class="text-center"> 
                                    <a href="{{ route('ranking.show', $item->id) }}" class="btn btn-info btn-sm">
                                        <i class="fa fa-info-circle"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
    <!-- Page level plugins -->
    <script src="{{ url('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ url('backend/js/demo/datatables-demo.js') }}"></script>
@endpush

@include('pages.admin.jobtype.create')
@include('pages.admin.jobtype.data')
