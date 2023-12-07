$(document).ready(function() {
    var sid = $('#schoolid').val();

    var userdataTable = $('#courseList').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            url: "action.php",
            type: "POST",
            data: { schoolid: sid , action: 'courseList' },
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

    $('#addCourse').click(function() {
        $('#id').val(sid);
        $('#courseModal').modal('show');
        $('#courseForm')[0].reset();
        $('.modal-title').html("<i class='fas fa-plus'></i> Add Course");
        $('#btn_action').val("courseAdd");
        $('#action').removeClass('btn-info');
        $('#action').addClass('btn-primary');
    });
    
    $(document).on( 'change', '#strandid',function() {
        var stid = $(this).val();
        $.ajax({
            url: "action.php",
            method: "POST",
            data: { strandid: stid, action: 'spclList'},
            success: function(data) {
                $('#spclid').html(data);
            }
        })
    });

    $(document).on('submit', '#courseForm', function(event) {
        event.preventDefault();
        $('#action').attr('disabled', 'disabled');
        var formData = $(this).serialize();
        $.ajax({
            url: "action.php",
            method: "POST",
            data: formData,
            success: function(data) {
                alert(data);
                $('#courseForm')[0].reset();
                $('#courseModal').modal('hide');
                $('#action').attr('disabled', false);
                userdataTable.ajax.reload();
                
            }
        })
    });

    $(document).on('click', '.update', function() {
        var id = $(this).attr("id");
        var btn_action = 'getCourse';
        $.ajax({
            url: "action.php",
            method: "POST",
            data: { id: id, schoolid: sid, btn_action: btn_action },
            dataType: "json",
            success: function(data) {
                $('#courseModal').modal('show');
                $('#id').val(id);
                $('#sid').val(data.school_id);
                $('#strandid').val(data.strand_id);
                $('#spclid').html(data.course_select_box);
                $('#spclid').val(data.specialized_id);
                $('.modal-title').html("<i class='fas fa-edit'></i> Edit Course");
                $('#btn_action').val('courseUpdate');
                $('#action').removeClass('btn-primary');
                $('#action').addClass('btn-info');
            }
        })
    });

    $(document).on('click', '.delete', function() {
        var id = $(this).attr("id");
        var btn_action = "courseDelete";
        if (confirm("Are you sure you want to delete this course?")) {
            $.ajax({
                url: "action.php",
                method: "POST",
                data: { id: id, schoolid: sid, btn_action: btn_action },
                success: function(data) {
                    userdataTable.ajax.reload();
                }
            })
        } else {
            return false;
        }
    });
});