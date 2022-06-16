<meta name="csrf-token" content="{{ csrf_token() }}" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Tipe Data Pekerjaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Nama Pekerjaan</label>
                    <input type="text" class="form-control" id="name">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary createBtn">Simpan Data</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        getDataFromDB();

        function resetModal() {
            $("#modalAdd").modal('hide');
            $("#name").val('');
        }

        $(".btnAdd").on('click', function() {
            $("#modalAdd").modal('show');

            //ADD DATA
            $(document).ready(function() {

                $('.createBtn').on('click', function() {
                    var name = $('#name').val();

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                'content')
                        }
                    })
                    $.ajax({
                        method: 'POST',
                        url: '{{ route('job-type.store') }}',
                        data: {
                            'job_name': name,
                        },
                        success: function(e) {
                            resetModal()
                            getDataFromDB();
                        }
                    })
                })
            })
        })
    });
</script>
