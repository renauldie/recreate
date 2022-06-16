@extends('layouts.admin.admin')

@push('addon-style')
    <link href="{{ url('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Kelola Data {{ $job_type->job_name }}</h1>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="card shadow mb-4">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Kelola Data Karyawan </h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('data-process.create') }}">
                            @csrf
                            <input type="text" name="period_id" value="{{ $period->id }}" readonly hidden>
                            <input type="text" name="emp_data" value="y" readonly hidden>
                            <input type="text" name="job_id" value="{{ $job_type->id }}" readonly hidden>
                            <table class="table table-borderless table-responsive-lg">
                                <thead class="">
                                    <tr>
                                        <th>No</th>
                                        <th scope="col">Nama Karyawan</th>
                                        @foreach ($criterias as $criteria)
                                            <th>{{ $criteria->criteria_name }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($countemp <= 0)
                                    <tr>
                                        <td colspan="5" class="text-center font-weight-bold"> Belum ada data karyawan</td>
                                    </tr>
                                    @else
                                        @for ($x = 0; $x < $n; $x++)
                                            <tr>
                                                <th>{{ $x + 1 }}</th>
                                                <td>{{ $employees[$x]->name }}</td>
                                                <td hidden>
                                                    <input type="number" name="emp_id{{ $x }}"
                                                        value="{{ $employees[$x]->id }}" readonly>
                                                </td>
                                                @for ($y = 0; $y < $cn; $y++)
                                                    <td>
                                                        <input type="number"
                                                            name="attr{{ $x }}{{ $y }}"
                                                            value="{{ $res[$x][$y] ?? 0 }}" class="form-control"
                                                            required>
                                                    </td>
                                                @endfor
                                            </tr>
                                        @endfor
                                        <tr>
                                            @if ($countemp <= 2)
                                            <td colspan="{{$y+2}}" class="font-weight-bold text-center text-danger">
                                                <a class="btn btn-danger" href="{{ route('employee.index')}}">Karyawan harus lebih dari 2!</a>
                                            </tr>
                                            @else
                                            <td colspan="{{$y+2}}">
                                                <button type="submit" href="#"
                                                    class="btn btn-success btn-icon-split btn-block">
                                                    <span class="text">Proses</span>
                                                </button>
                                            </td>
                                            @endif
                                        </tr>
                                    @endif
                                </tbody>
                            </table>

                        </form>
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
