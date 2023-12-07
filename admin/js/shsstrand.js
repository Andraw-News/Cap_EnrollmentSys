$(document).ready(function() {

    var userdataTable = $('#strandList').DataTable({
        scrollX: true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            url: "action.php",
            type: "POST",
            data: { action: 'strandList' },
            dataType: "json"
        },
        "columnDefs": [{
            "targets": [0,4],
            "orderable": false,
        }, ],
        'rowCallback': function(row, data, index) {
            $(row).find('td').addClass('align-middle')
            $(row).find('td:eq(0), td:eq(4)').addClass('text-center')
        },
    });

    $('#addStrand').click(function() {
        $('#strandModal').modal('show');
        $('#strandForm')[0].reset();
        $('.modal-title').html("<i class='fas fa-plus'></i> Add Strand");
        $('#btn_action').val("strandAdd");
        $('#action').removeClass('btn-info');
        $('#action').addClass('btn-primary');
    });

    $(document).on('submit', '#strandForm', function(event) {
        event.preventDefault();
        $('#action').attr('disabled', 'disabled');
        var formData = $(this).serialize();
        $.ajax({
            url: "action.php",
            method: "POST",
            data: formData,
            success: function(data) {
                $('#strandForm')[0].reset();
                $('#strandModal').modal('hide');
                $('#action').attr('disabled', false);
                userdataTable.ajax.reload();
                alert(data);
            }
        })
    });

    $(document).on('click', '.update', function() {
        var id = $(this).attr("id");
        var btn_action = 'getStrand';
        $.ajax({
            url: "action.php",
            method: "POST",
            data: { id: id, btn_action: btn_action },
            dataType: "json",
            success: function(data) {
                $('#strandModal').modal('show');
                $('#id').val(id);
                $('#trackid').val(data.track_id);
                $('#name').val(data.strand_name);
                $('#description').val(data.strand_descript);
                $('.modal-title').html("<i class='fas fa-edit'></i> Edit Strand");
                $('#btn_action').val('strandUpdate');
                $('#action').removeClass('btn-primary');
                $('#action').addClass('btn-info');
            }
        })
    });

    $(document).on('click', '.delete', function() {
        var id = $(this).attr("id");
        var btn_action = "strandDelete";
        if (confirm("Are you sure you want to delete this strand?")) {
            $.ajax({
                url: "action.php",
                method: "POST",
                data: { id: id, btn_action: btn_action },
                success: function(data) {
                    $('#alert_action').fadeIn().html('<div class="alert alert-info">' + data + '</div>');
                    userdataTable.ajax.reload();
                }
            })
        } else {
            return false;
        }
    });
});