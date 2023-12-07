$(document).ready(function() {

    var userdataTable = $('#specialSubjList').DataTable({
        scrollX: true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            url: "action.php",
            type: "POST",
            data: { action: 'SpecialSubjList' },
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

    $('#addSubj').click(function() {
        $('#subjModal').modal('show');
        $('#subjForm')[0].reset();
        $('.modal-title').html("<i class='fas fa-plus'></i> Add Specialization");
        $('#btn_action').val("subjAdd");
        $('#action').removeClass('btn-info');
        $('#action').addClass('btn-primary');
    });

    $(document).on('submit', '#subjForm', function(event) {
        event.preventDefault();
        $('#action').attr('disabled', 'disabled');
        var formData = $(this).serialize();
        $.ajax({
            url: "action.php",
            method: "POST",
            data: formData,
            success: function(data) {
                $('#subjForm')[0].reset();
                $('#subjModal').modal('hide');
                $('#action').attr('disabled', false);
                userdataTable.ajax.reload();
                alert(data);
            }
        })
    });

    $(document).on('click', '.update', function() {
        var id = $(this).attr("id");
        var btn_action = 'getSubj';
        $.ajax({
            url: "action.php",
            method: "POST",
            data: { id: id, btn_action: btn_action },
            dataType: "json",
            success: function(data) {
                $('#subjModal').modal('show');
                $('#id').val(id);
                $('#strandid').val(data.strand_id);
                $('#name').val(data.specialization_name);
                $('.modal-title').html("<i class='fas fa-edit'></i> Edit Specialization");
                $('#btn_action').val('subjUpdate');
                $('#action').removeClass('btn-primary');
                $('#action').addClass('btn-info');
            }
        })
    });

    $(document).on('click', '.delete', function() {
        var id = $(this).attr("id");
        var btn_action = "subjDelete";
        if (confirm("Are you sure you want to delete this subj?")) {
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