@extends('layouts.admin.admin')

@push('addon-style')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ url('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
        </div>

        <div class="row">
            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Total Periode Giling</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $periods }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Karyawan</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$employee}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Kriteria</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $criterias }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-link fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Tipe Pekerjaan
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jobtypes }}</div>

                            </div>
                            <div class="col-auto">
                                <i class="fas fa-link fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        {{-- table --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Data Periode Giling
                    </h6>
                    <a class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm btnAdd">
                        <i class="fas fa-plus fa-sm text-white-50"></i>
                        Tambah Data Periode Giling
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody id="dataDestination">
                        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col md-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h6 class="m-0 font-weight-bold text-primary">
                                Data Index Ratio
                            </h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Jumlah Kriteria</th>
                                        <th>Nilai</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Jumlah Kriteria</th>
                                        <th>Nilai</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php $num = 1 ?>
                                    @foreach ($ir_value as $data)
                                        <tr>
                                            <td>{{ $num++ }}</td>
                                            <td>{{ $data->total_criteria }}</td>
                                            <td>{{ $data->value }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col md-6"></div>
        </div>
        {{-- table --}}
        
    </div>
@endsection

@push('addon-script')
    <!-- Page level plugins -->
    <script src="{{ url('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ url('backend/js/demo/datatables-demo.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
@endpush

@include('pages.admin.period.index')
@include('pages.admin.period.create')
