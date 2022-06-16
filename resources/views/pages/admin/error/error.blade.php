@push('addon-style')
    <link href="{{ url('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
@endpush
@extends('includes.admin.styles')
@extends('includes.admin.script')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script>
	$(document).ready(function(){
		$("#myModal").modal('show');
	});
</script>
</head>
<body>
<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Error</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                
				<p>Error : {{ $message }}</p>
                @if ($param == 1)
                <a href="{{ route('dashboard')}}" class="btn btn-primary btn-block">Ok</a>
                @elseif($param == 2)
                <a href="{{ route('ranking.index')}}" class="btn btn-primary btn-block">Ok</a>
                @endif
            </div>
        </div>
    </div>
</div>

@push('addon-script')
    <!-- Page level plugins -->
    <script src="{{ url('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ url('backend/js/demo/datatables-demo.js') }}"></script>
@endpush