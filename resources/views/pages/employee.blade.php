@extends('layouts.app')

@push('addon-style')
    <link href="{{ url('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <div class="container">
        <h4 class="h4 mb-n4 mt-4 text-center">Data Karyawan Per-Tipe</h4>

        <div class="card shadow mb-2">
            <div class="card-header py-3">
                <div class="d-sm-flex align-items-center justify-content-between mb-2">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Data Karyawan
                    </h6>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Karyawan</th>
                            <th>Tipe Pekerjaan</th>
                            <th>Kontrak Kerja</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Nama Karyawan</th>
                            <th>Tipe Pekerjaan</th>
                            <th>Kontrak Kerja</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @php
                            $no = 1;
                            $today = date('Y-m-d');
                        @endphp
                        @foreach($employee as $ppl)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $ppl->name }}</td>
                                <td>{{ $ppl->job_type->job_name }}</td>
                                @php
                                    $contract = \App\Helpers\Helper::getStartContract($ppl->id);
                                @endphp
                                @if($contract[1] < $today)
                                    <td>Kontrak habis</td>
                                @else
                                    <td>{{ $contract[0] ?? '-' }} - {{ $contract[1] ?? '-' }}</td>
                                @endif
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
