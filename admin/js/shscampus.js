$(document).ready(function() {

    var userdataTable = $('#schoolList').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            url: "action.php",
            type: "POST",
            data: { action: 'schoolList' },
            dataType: "json"
        },
        "columnDefs": [{
        "targets": [0,3],
        "orderable": false,
        }, ],
        'rowCallback': function(row, data, index) {
            $(row).find('td').addClass('align-middle')
            $(row).find('td:eq(0), td:eq(3)').addClass('text-center')
        },
    });

    $('#addSchool').click(function() {
        $('#schoolModal').modal('show');
        $('#schoolForm')[0].reset();
        $('.modal-title').html("<i class='fas fa-plus'></i> Add School");
        $('#action').val("Add");
        $('#btn_action').val("schoolAdd");
        $('#action').removeClass('btn-info');
        $('#action').addClass('btn-primary');
    });

    $(document).on('submit', '#schoolForm', function(event) {
        event.preventDefault();
        $('#action').attr('disabled', 'disabled');
        var formData = $(this).serialize();
        $.ajax({
            url: "action.php",
            method: "POST",
            data: formData,
            success: function(data) {
                $('#schoolForm')[0].reset();
                $('#schoolModal').modal('hide');
                $('#action').attr('disabled', false);
                userdataTable.ajax.reload();
                alert(data);
            }
        })
    });

    $(document).on('click', '.update', function() {
        var id = $(this).attr("id");
        var btn_action = 'getSchool';
        $.ajax({
            url: "action.php",
            method: "POST",
            data: { id: id, btn_action: btn_action },
            dataType: "json",
            success: function(data) {
                $('#schoolModal').modal('show');
                $('#schoolid').val(id);
                $('#name').val(data.name);
                $('#code').val(data.code);
                $('#description').val(data.descript);
                $('.modal-title').html("<i class='fas fa-edit'></i> Edit School");
                $('#btn_action').val('schoolUpdate');
                $('#action').removeClass('btn-primary');
                $('#action').addClass('btn-info');
            }
        })
    });

    $(document).on('click', '.delete', function() {
        var id = $(this).attr("id");
        var btn_action = "schoolDelete";
        if (confirm("Are you sure you want to delete this school?")) {
            $.ajax({
                url: "action.php",
                method: "POST",
                data: { id: id, btn_action: btn_action },
                success: function(data) {
                    alert(data);
                    userdataTable.ajax.reload();
                }
            })
        } else {
            return false;
        }
    });
});