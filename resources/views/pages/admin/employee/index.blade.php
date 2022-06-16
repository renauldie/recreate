@extends('layouts.admin.admin')

@push('addon-style')
    <link href="{{ url('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <!-- Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalTitle"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('import-employee') }}" method="post" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="importModalTitle">Import Data Karyawan (Excel)</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <label>Pilih file excel</label>
                        <div class="form-group">
                            <input type="file" name="file" required="required">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
            </form>
        </div>
    </div>
    </div>

    <div class="modal fade" id="employeeDetail" tabindex="-1" role="dialog" aria-labelledby="employeeDetailTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalTitle">Data Karyawan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img class="img-fluid z-depth-1" src="" class="img-thumbnail" id="image">
                    <div class="table-responsive table-borderless">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>Nama Lengkap</th>
                                    <td id="nama"></td>
                                </tr>
                                <tr>
                                    <th>NIK</th>
                                    <td id="nik"></td>
                                </tr>
                                <tr>
                                    <th>Tanggal Lahhir</th>
                                    <td id="tgl"></td>
                                </tr>
                                <tr>
                                    <th>Jenis Kelamin</th>
                                    <td id="gender"></td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td id="address"></td>
                                </tr>
                                <tr>
                                    <th>Kontak</th>
                                    <td id="phone"></td>
                                </tr>
                                <tr>
                                    <th>Tipe Pekerjaan</th>
                                    <td id="jobtype"></td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td id="status"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Data Karyawan</h1>
        {{-- notifikasi form validasi --}}
        @if ($errors->has('file'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('file') }}</strong>
            </span>
        @endif

        {{-- notifikasi sukses --}}
        @if ($sukses = Session::get('sukses'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $sukses }}</strong>
            </div>
        @endif
        
        <div class="card shadow mb-2">
            <div class="card-header py-3">
                <div class="d-sm-flex align-items-center justify-content-between mb-2">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Data Karyawan
                    </h6>
                    <div class="row justify-content-between">
                        <a href="{{ route('employee.create') }}"
                            class="d-sm-inline-block btn btn-sm btn-primary shadow-sm mr-2">
                            <i class="fas fa-plus fa-sm text-white-50"></i>
                            Tambah Data Karyawan
                        </a>
                        <button class="d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal"
                            data-target="#importModal">
                            <i class="fas fa-plus fa-sm text-white-50"></i>
                            Tambah Data Karyawan (excel)
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Gender</th>
                                <th>Pekerjaan</th>
                                <th>Kontak</th>
                                <th>Awal Kontrak</th>
                                <th>Akhir Kontrak</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Gender</th>
                                <th>Pekerjaan</th>
                                <th>Kontak</th>
                                <th>Awal Kontrak</th>
                                <th>Akhir Kontrak</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @php $no = 1 ;@endphp
                            @forelse ($items as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item->name }}</td>
                                    @if ($item->gender == 'male')
                                        <td>Pria</td>
                                    @else
                                        <td>Wanita</td>
                                    @endif
                                    <td>{{ $item->job_type->job_name }}</td>
                                    <td>{{ $item->phone_number }}</td>
                                    @php
                                        $emp = \App\Helpers\Helper::getStartContract($item->id);
                                    @endphp
                                    <td>{{ $emp[0] ?? '-' }}</td>
                                    <td>{{ $emp[1] ?? '-' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('employee.edit', $item->id) }}" class="btn btn-info btn-sm">
                                            <i class="fa fa-pencil-alt"></i>
                                        </a>

                                        <form action="{{ route('employee.destroy', $item->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('delete')
                                            <button href="" class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                        <a class="btn btn-success btn-sm btnInfo" itemid="{{ $item->id }}">
                                            <i class="fa fa-info-circle"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script>
        $(document).ready(function() {
            $('.btnInfo').on('click', function() {
                var idData = $(this).attr("itemId");
                $.ajax({
                    url: '{{ route('employee.show', '') }}/' + idData,
                    method: 'GET',
                    success: function(data) {
                        res = data;
                        $('#employeeDetail').modal('show');
                        document.getElementById("nama").innerHTML = res.name;
                        document.getElementById("nik").innerHTML = res.nik;
                        document.getElementById("tgl").innerHTML = res.date_of_birth;
                        document.getElementById("gender").innerHTML = res.gender;
                        document.getElementById("address").innerHTML = res.address;
                        document.getElementById("phone").innerHTML = res.phone_number;
                        document.getElementById("jobtype").innerHTML = res.job_type.job_name;
                        document.getElementById("status").innerHTML = res.status;
                        $('#image').append(
                            `<img class="img-fluid z-depth-1" src="/storage/${res.image}" class="img-thumbnail" id="image">`
                        )
                    }
                })
            });
        })
    </script>
@endsection

@push('addon-script')
    <!-- Page level plugins -->
    <script src="{{ url('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ url('backend/js/demo/datatables-demo.js') }}"></script>
@endpush
