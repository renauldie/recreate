<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Periode</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Tanggal Mulai:</label>
                    <input type="text" class="form-control" id="edit_start_date">
                </div>
                <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Tanggal Selesai:</label>
                    <input type="text" class="form-control" id="edit_end_date">
                </div>
                {{-- <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Tanggal ss:</label>
                    <input type="text" class="form-control" id="edit_status">
                </div> --}}
                <div class="form-group">
                    <label for="" class="col-form-label">Status</label>
                    <select class="form-control" id="edit_status">
                        <option value="ACTIVE">ACTIVE</option>
                        <option value="DEACTIVE">DEACTIVE</option>
                    </select>
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
        $("#edit_end_date").val('');
        $("#edit_start_date").val('');
    }

    function getDataFromDB() {
        var x = ''
        var num = 1;
        $.ajax({
            method: 'GET',
            url: '{{ route('period.index') }}',
            success: function(res) {
                $.each(res, function(index, item) {
                    x = x + '<tr>' +
                        '<td>' + num++ + '</td>' +
                        '<td>' + item.start_date + '</td>' +
                        '<td>' + item.end_date + '</td>' +
                        '<td id="dates" class="dates" name="status">' + item.status + '</td>' +
                        '<td class="text-center">' +
                        '<a class="btn btn-info btn-sm mr-1 btnEdit" itemId=' + item.id +
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
                        url: '{{ route('period.show', '') }}/' + idData,
                        method: 'GET',
                        success: function(data) {
                            $("#edit_start_date").val(data.start_date);
                            $("#edit_end_date").val(data.end_date);
                            $("#edit_status").val(data.status);
                            $("#modalEdit").modal('show');
                            $(".btnUpdate").attr("idEdit", data.id);
                            $(".btnUpdate").on('click', function() {
                                idData = $(this).attr("idEdit");
                                startDate = $("#edit_start_date").val();
                                endDate = $("#edit_end_date").val();
                                status = $('select#edit_status').val();
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
                                    url: "{{ route('period.update', '') }}/" +
                                        idData,
                                    data: {
                                        // 'idData': idData,
                                        'startDate': startDate,
                                        'endDate': endDate,
                                        'status': status,
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
                        url: '{{ route('period.destroy', '') }}/' + idData,
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
