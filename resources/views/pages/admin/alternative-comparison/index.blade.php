@extends('layouts.admin.admin')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <h6 class="h4 font-weight-bold mb-4 text-gray-800">Perbandingan Matrix Berpasangan ({{ $cname->criteria_name}})</h6>

        <!-- DataTales Example -->
        <div class="row mb-15">
            <div class="col-md-7">
                <div class="card shadow mb-2">
                    <div class="card-header py-3">
                        <div class="d-sm-flex align-items-center justify-content-between mb-2">
                            <h6 class="m-0 font-weight-bold text-primary">
                                Perbandingan Matrix
                            </h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Alternatif</th>
                                        @php
                                            $n = \App\Helpers\Helper::countAlternativeById($jobid);
                                            for ($x = 0; $x <= $n - 1; $x++) {
                                                echo '<th>' . \App\Helpers\Helper::getEmployeeName($x, $jobid) . '</th>';
                                            }
                                        @endphp
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        for ($x = 0; $x <= $n - 1; $x++) {
                                            echo '<tr>';
                                            echo '<th>' . \App\Helpers\Helper::getEmployeeName($x, $jobid) . '</th>';
                                            for ($y = 0; $y <= $n - 1; $y++) {
                                                echo '<td>' . round($matrix[$x][$y], 5) . '</td>';
                                            }
                                            echo '</tr>';
                                        }
                                    @endphp
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Jumlah</th>
                                        @php
                                            for ($i = 0; $i <= $n - 1; $i++) {
                                                echo '<th>' . round($countrow[$i], 5) . '</th>';
                                            }
                                        @endphp
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h6 class="h4 font-weight-bold mb-4 mt-3 text-gray-800">Matrix Nilai Alternatif</h6>
        <div class="row mt-4">
            @if ($const_ratio * 100 > 10)
                <div class="col-md-12">
                    <div class="alert alert-danger" role="alert">
                        Rasio Konsistensi Melebihi 10%. Mohon ulangi penginputan!
                    </div>
                </div>
            @endif
            <div class="col-md-12">
                <div class="card shadow mb-2">
                    <div class="card-header py-3">
                        <div class="d-sm-flex align-items-center justify-content-between mb-2">
                            <h6 class="m-0 font-weight-bold text-primary">
                                Perbandingan Matrix
                            </h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Alternatif</th>
                                        @php
                                            $n = \App\Helpers\Helper::countAlternativeById($jobid);
                                            // print_r($n . ', id = ' . $id);
                                            for ($x = 0; $x <= $n - 1; $x++) {
                                                echo '<th>' . \App\Helpers\Helper::getEmployeeName($x, $jobid) . '</th>';
                                            }
                                        @endphp
                                        <th>Jumlah</th>
                                        <th>Priority Vector</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        for ($x = 0; $x <= $n - 1; $x++) {
                                            echo '<tr>';
                                            echo '<th>' . \App\Helpers\Helper::getEmployeeName($x, $jobid) . '</th>';
                                            for ($y = 0; $y <= $n - 1; $y++) {
                                                echo '<td>' . round($matrix_n[$x][$y], 5) . '</td>';
                                            }
                                            echo '<td>' . round($countcol[$x], 5) . '</td>';
                                            echo '<td>' . round($pvalue[$x], 5) . '</td>';
                                            echo '</tr>';
                                        }
                                    @endphp
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="{{ $n + 2 }}">Principe Eign Vector (λ maks)</th>
                                        <th>{{ round($eign_vector, 8) }}</th>
                                    </tr>
                                    <tr>
                                        <th colspan="{{ $n + 2 }}">Consistency Index</th>
                                        <th>{{ number_format($const_index, 8) }}</th>
                                    </tr>
                                    <tr>
                                        <th colspan="{{ $n + 2 }}">Consistency Ratio</th>
                                        <th>{{ round($const_ratio * 100, 5) }} %</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3 mb-5">
            <div class="col-lg-12">
                <form action="{{ route('throw-alternative') }}" method="POST">
                    @csrf
                    <input type="text" value="{{ $jobid }}" name="job_id" readonly hidden>
                    <input type="text" value="{{ $param + 1 }}" name="param" readonly hidden>
                    <button class="btn btn-secondary float-right">Next Process <i class="ml-2 fas fa-arrow-right"></i></button>
                </form>
            </div>
        </div>
    </div>
@endsection
