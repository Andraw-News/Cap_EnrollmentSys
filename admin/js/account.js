$(document).ready(function() {

    var userdataTable = $('#accountList').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            url: "action.php",
            type: "POST",
            data: { action: 'accountList' },
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

    $('#addAccount').click(function() {
        $('#action').attr('disabled', 'disabled');
        $('#accountModal').modal('show');
        $('#accountForm')[0].reset();
        $('.modal-title').html("<i class='fas fa-plus'></i> Add Account");
        $('#action').val("Add");
        $('#btn_action').val("accountAdd");
        $('#action').removeClass('btn-info');
        $('#action').addClass('btn-primary');
    });

    $(document).on('focusout', '#cpassword', function(event) {
        var pass = $('#password').val();
        var cpass = $(this).val();
        if (pass !== cpass) {
            alert("Confirm Password doesn't match!");
        } else {
            $('#action').attr('disabled', false);
        }  
              
    });

    $(document).on('click', '.view', function() {
        var id = $(this).attr("id");
        var btn_action = 'viewAccount';
        $.ajax({
            url: "action.php",
            method: "POST",
            data: { id: id, btn_action: btn_action },
            success: function(data) {
                $('#accountViewModal').modal('show');
                $('#accountDetails').html(data);
            }
        })
    });

    $(document).on('submit', '#accountForm', function(event) {
        event.preventDefault();
        $('#action').attr('disabled', 'disabled');
        var formData = $(this).serialize();
        $.ajax({
            url: "action.php",
            method: "POST",
            data: formData,
            success: function(data) {
                $('#accountForm')[0].reset();
                $('#accountModal').modal('hide');
                $('#action').attr('disabled', false);
                userdataTable.ajax.reload();
                alert(data);
            }
        })
    });

    $(document).on('click', '.update', function() {
        $('#action').attr('disabled', 'disabled');
        var id = $(this).attr("id");
        var btn_action = 'getAccount';
        $.ajax({
            url: "action.php",
            method: "POST",
            data: { id: id, btn_action: btn_action },
            dataType: "json",
            success: function(data) {
                $('#accountModal').modal('show');
                $('#id').val(id);
                $('#name').val(data.account_name);
                $('#email').val(data.email);
                $('#schoolid').val(data.school_id);
                $('.modal-title').html("<i class='fas fa-edit'></i> Edit Account");
                $('#btn_action').val('accountUpdate');
                $('#action').removeClass('btn-primary');
                $('#action').addClass('btn-info');
            }
        })
    });

    $(document).on('click', '.delete', function() {
        var id = $(this).attr("id");
        var btn_action = "accountDelete";
        if (confirm("Are you sure you want to delete this account?")) {
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