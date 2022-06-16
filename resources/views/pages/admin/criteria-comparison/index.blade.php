@extends('layouts.admin.admin')

@push('addon-style')
    <link href="{{ url('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Perbandingan Kriteria {{ $job->job_type->job_name }}</h1>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="card shadow mb-4">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Kelola Data Kriteria</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('criteria-comparison.create')}}">
                            @csrf
                            <input type="text" name="id" value="{{ $job->job_type->id }}" readonly hidden>
                            <table class="table table-borderless">
                                <thead class="">
                                    <tr>
                                        <th scope="col" colspan="2">Prioritas</th>
                                        <th scope="col">Nilai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $num = 0;
                                    @endphp
                                    @for ($x = 0; $x <= $n - 2; $x++)
                                        @for ($y = $x + 1; $y <= $n - 1; $y++)
                                    @php
                                        $num++;
                                    @endphp
                                            <tr>
                                                <td>
                                                    <div class="field">
                                                        <input class="form-check-input ml-1" name="choose{{$num}}" value="1" checked="" class="hidden" type="radio">
                                                        <label class="form-check-label ml-4" for="">
                                                            {{ $data[$x]->criteria_name }}
                                                        </label>
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="field">
                                                    <input class="form-check-input" name="choose{{$num}}" value="2" class="hidden" type="radio">
                                                        <label class="form-check-label" for="">
                                                            {{ $data[$y]->criteria_name }}
                                                        </label>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        @php
                                                            $getCompareCriteriaValue = \App\Helpers\Helper::getCompareCriteriaValue($data[$x]->id, $data[$y]->id);
                                                        @endphp
                                                        <input type="text" name="value{{$num}}" class="form-control" value="{{ round($getCompareCriteriaValue, 2) }}" id="">
                                                    </div>
                                                </td>
                                            </tr>
                                        @endfor
                                    @endfor
                                </tbody>
                            </table>
    
                            <button type="submit" href="#" class="btn btn-success btn-icon-split btn-block">
                                <span class="text">Proses</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="card shadow mb-4">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Nilai Tingkat Kepentingan</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Nilai</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Nilai</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Sama Pentingnya (Equal Importance)</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Sama hingga sedikit lebih penting</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Sedikit lebih penting (Slightly more importance)</td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Sedikit lebih hingga jelas lebih penting</td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>Jelas lebih penting (Materially more importance)</td>
                                    </tr>
                                    <tr>
                                        <td>6</td>
                                        <td>Jelas hingga sangat jelas lebih penting</td>
                                    </tr>
                                    <tr>
                                        <td>7</td>
                                        <td>Sangat jelas lebih penting (Significantly more importance)</td>
                                    </tr>
                                    <tr>
                                        <td>8</td>
                                        <td>Sangat jelas hingga mutlak lebih penting</td>
                                    </tr>
                                    <tr>
                                        <td>9</td>
                                        <td>Mutlak lebih penting (Absolutely more importance)</td>
                                    </tr>
                                </tbody>
                            </table>
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
