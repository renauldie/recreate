<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data job-typee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Nama Pekerjaan</label>
                        <input type="text" class="form-control" id="edit_nama">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary btnUpdate idEdit" idEdit="">Ubah Data</button>
            </div>
        </div>
    </div>
</div>

<script>
    //READ DATA
    function resetModalEdit() {
        $("#modalEdit").modal('hide');
        $("#edit_nama").val('');
    }

    function getDataFromDB() {
        var x = ''
        var num = 1;
        $.ajax({
            method: 'GET',
            url: '{{ route('job-type.show', '') }}/' + num,
            success: function(res) {
                $.each(res, function(index, item) {
                    x = x + '<tr>' +
                        '<td>' + num++ + '</td>' +
                        '<td>' + item.job_name + '</td>' +
                        '<td class="text-center"><a class="btn btn-info btn-sm mr-1 btnEdit" itemId=' + item.id +
                        '><i class="fa fa-pencil-alt"></i></a>' +
                        '<a class="btn btn-danger btn-sm btnDelete" itemId=' + item.id +
                        '><i class="fa fa-trash"></i></a>' +
                        '</td>' +
                        '</tr>';
                })
                $('#dataDestination').html(x);
                $(".btnEdit").on('click', function() {
                    var idData = $(this).attr("itemId");
                    $.ajax({
                        url: "{{ url('admin/job-type/edit') }}/" + idData,
                        method: 'GET',
                        success: function(data) {
                            $("#modalEdit").modal('show');
                            $("#edit_nama").val(data.job_name);
                            $(".btnUpdate").attr("idEdit", data.id);
                            $(".btnUpdate").on('click', function() {
                                idData = $(this).attr("idEdit");
                                jobName = $("#edit_nama").val();
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $(
                                            'meta[name="csrf-token"]'
                                        ).attr(
                                            'content')
                                    }
                                });
                                $.ajax({
                                    method: "PUT",
                                    url: "{{ route('job-type.update', '') }}/" +
                                        idData,
                                    data: {
                                        'jobName': jobName,
                                    },
                                    success: function(o) {
                                        resetModalEdit();
                                        getDataFromDB();
                                    }
                                });
                            });
                        }
                    })
                })
                $('.btnDelete').on('click', function() {
                    var idData = $(this).attr("itemId");
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                'content')
                        }
                    });
                    $.ajax({
                        method: "delete",
                        url: '{{ route('job-type.destroy', '') }}/' + idData,
                        success: function(e) {
                            alert('Data dihapus')
                            getDataFromDB();
                        }
                    })
                })

            }
        })
    }
</script>
