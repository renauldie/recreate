@extends('layouts.app')

@section('content')
    <div class="container">
        <h4 class="h4 mb-n4 mt-4 text-center">Data Tipe Karyawan</h4>
        <div class="row">
            @foreach($jobs as $job)
                <div class="col-xl-4 col-md-6 mb-4 mt-5">
                    <div class="card border-bottom-secondary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-gray-700 text-uppercase mb-1">
                                        {{ $job->job_name }}
                                        @foreach($job->employee as $emp)
                                            @if($emp)
                                                ({{ $emp->total}})
                                            @else
                                                (-)
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <a href="{{ route('employee', $job->id) }}">
                                        <i class="fas fa-arrow-right text-gray-700"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
