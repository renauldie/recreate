@extends('layouts.admin.admin')

@push('addon-style')
    <link href="{{ url('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Hasil Perhitungan ({{ $job->job_name }})</h1>
        <h1 class="h6 mb-4 text-gray-600 mt-n2 font-weight-bold font-italic">Periode {{ $period->start_date }} -
            {{ $period->end_date }}</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-2">
            <div class="card-header py-3">
                <div class="d-sm-flex align-items-center justify-content-between mb-2">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Hasil Perhitungan Karyawan
                    </h6>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-light">
                            <tr>
                                <th>Priority Vector</th>
                                <th>Total Kriteria Pembanding</th>
                                @for ($i = 0; $i < $n; $i++)
                                    <th>{{ \App\Helpers\Helper::getAlternativeName($i, $jobid) }}</th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $sumCriteria = \App\Helpers\Helper::sumCriteria($jobid);
                                $countAlternative = \App\Helpers\Helper::countAlternativeById($jobid);
                                $num = 0;
                            @endphp
                            @for ($i = 0; $i < $sumCriteria; $i++)
                                <tr>
                                    <td>{{ \App\Helpers\Helper::getCriteriaName($i, $jobid) }}</td>
                                    <td>{{ round($pvCriteria[$i]->value, 5) }}</td>

                                    @for ($x = 0; $x <= $countAlternative - 1; $x++)
                                        @php
                                            $alternateId = \App\Helpers\Helper::getAlternativeId($x, $jobid);
                                            $criteriaId = \App\Helpers\Helper::getCriteriaId($i, $jobid);
                                            $pvRes = \App\Helpers\Helper::getAlternativePV($alternateId, $criteriaId);
                                        @endphp
                                        <td>{{ round($pvRes, 5) }}</td>
                                    @endfor
                                </tr>
                            @endfor
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2">Jumlah</th>
                                @for ($i = 0; $i <= $countAlternative - 1; $i++)
                                    <th>{{ round($value[$i], 5) }}</th>
                                @endfor
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <h6 class="h4 font-weight-bold mb-2 mt-5 text-gray-800">Hasil Akhir Penilaian</h6>

        <div class="row mt-5">
            <div class="col-md-7">
                <div class="card shadow mb-2">
                    <div class="card-header py-3">
                        <div class="d-sm-flex align-items-center justify-content-between mb-2">
                            <h6 class="m-0 font-weight-bold text-primary">
                                Hasil Perhitungan
                            </h6>
                            <div class="row justify-content-between">
                                <form action="{{ route('export-spk-res') }}" method="POST">
                                    @csrf
                                    <input type="text" value="{{$job->id}}" name="jobid" readonly hidden>
                                    <input type="text" value="{{$period->id}}" name="period" readonly hidden>
                                    <button class="d-sm-inline-block btn btn-sm btn-primary shadow-sm mr-2">
                                        <i class="fas fa-plus fa-sm text-white-50"></i>
                                        Export data
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <form action="{{ route('ranking.create') }}">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Peringkat</th>
                                            <th>Alternatif (Karyawan)</th>
                                            <th>Nilai Akhir</th>
                                            <th>Opsi Kontrak Karyawan (bulan)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($result as $res)
                                            @php
                                                $num++;
                                                $contract = App\Helpers\Helper::empContract($num, $totalAlt);
                                            @endphp
                                            <tr>
                                                <td>{{ $num }}</td>
                                                <td>{{ $res->employee->name }}</td>
                                                <td>{{ round($res->value, 6) }}</td>
                                                <td>
                                                    <div class="form-group">
                                                        @csrf
                                                        <input type="number" name="empid-{{ $num }}"
                                                            value="{{ $res->employee->id }}" readonly hidden>
                                                        <input type="text" name="contract-{{ $num }}"
                                                            class="form-control" value="{{ $contract }}">
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <input type="text" name="totalemp" value="{{ $num }}" readonly hidden>
                                </table>
                                <button class="btn btn-success btn-block">Process</button>
                            </form>
                        </div>
                    </div>
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
