@extends('layouts.admin.admin')

@push('addon-style')
    <link href="{{ url('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Data Tipe Pekerjaan</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-2">
            <div class="card-header py-3">
                <div class="d-sm-flex align-items-center justify-content-between mb-2">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Data Pekerjaan
                    </h6>
                    <a class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm btnAdd">
                        <i class="fas fa-plus fa-sm text-white-50"></i>
                        Tambah Data Pekerjaan
                    </a>
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
                        <tbody id="dataDestination">
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
