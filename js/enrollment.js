$(document).ready(function () {
    $('.regform').hide();
    $('#verForm').hide();
    $(document).on('submit', '#regForm', function (event) {
        event.preventDefault();
        var formData = $('#regForm').serialize();
        $.ajax({
            url: "inc/action.php",
            method: "POST",
            data: formData,
            success: function (data) {
                $('#inputSType').val();
                $('#verifyID')[0].reset();
                $('#regForm')[0].reset();
                $('#msg').html(data);
                $('#myModal').modal('show');
                $('.regform').hide();
                $('#verifyID').prop("hidden", true);
            },
        })
    });

    $(document).on('submit', '#verifyID', function (event) {
        var id = $('#studId').val();
        event.preventDefault();
        $.ajax({
            url: "inc/action.php",
            method: "POST",
            data: { studid: id, action: 'getStudDetails' },
            dataType: "json",
            success: function (data) {
                $('#action').val('updateDetails');
                $('#studentid').val(id);
                $('#inputLRN').val(data.LRN);
                $('#inputRegId').val(data.reg_id);
                $('#inputSchool').val(data.school_id);
                $('#inputGrade').val(data.grade_lvl);
                $('#inputSem').val(data.semester);
                $('#inputLname').val(data.stud_Lname);
                $('#inputFname').val(data.stud_Fname);
                $('#inputMname').val(data.stud_Mname);
                $('#inputBDate').val(data.BirthDate);
                $('#inputBPlace').val(data.BirthPlace);
                $('#inputAge').val(data.Age);
                $('#inputEmail').val(data.stud_email);
                $('#caddr').val(data.Current_Address);
                $('#haddr').val(data.Home_Address);
                $('#inputPFname').val(data.ParentFname);
                $('#inputPFcontact').val(data.ParentFContact);
                $('#inputPMname').val(data.ParentMname);
                $('#inputPMcontact').val(data.ParentMContact);
                $('#inputGname').val(data.GuardianName);
                $('#inputGcontact').val(data.GuardianContact);
                var btn_action = 'getList';
                $.ajax({
                    url: "inc/action.php",
                    method: "POST",
                    data: { id: id, btn_action: btn_action },
                    dataType: "json",
                    success: function (data) {
                        $('#inputTrack').html(data.track_select_box);
                        $('#inputTrack').val(data.track_id);
                        $('#inputStrand').html(data.course_select_box);
                        $('#inputStrand').val(data.offer_id);
                    }
                })
                $('.regform').show();
            },
        })
    });

    $("#inputSType").change(function () {
        var type = $(this).val();
        if (type === "NEW") {
            $.ajax({
                url: "inc/action.php",
                method: "POST",
                data: { action: 'getRegId' },
                success: function (data) {
                    $('#verifyID').prop("hidden", true);
                    $('#action').val('saveDetails');
                    $('#inputLRN').removeClass('form-control-plaintext');
                    $('#inputLRN').addClass('form-control');
                    $('#inputLRN').prop("readonly", false);
                    $('#inputRegId').val(data);
                    $('.regform').show();
                },
            })
        } else {
            $('#verifyID').prop("hidden", false);
            $('#inputLRN').removeClass('form-control');
            $('#inputLRN').addClass('form-control-plaintext');
            $('#inputLRN').prop("readonly", true);
            $('.regform').hide();
            $('#verForm').show();
        }
        $('#stype').val(type);
    });
    $("#sameaddr").change(function () {
        var addr = $('#caddr').val();
        if ($(this).prop("checked")) {
            $('#haddr').val(addr);
        }
    });

    $(document).on('change', '#reqDocu', function () {
        var regid = $('#inputRegId').val();
        var name = $(this).attr("name");
        // Get the selected file
        var fileInput = $("#reqDocu")[0];
        var file = fileInput.files[0];

        // Check if a file is selected
        if (file) {
            // Create a FormData object
            var formData = new FormData();
            formData.append("file", file);
            formData.append("action", "uploadsFile");
            formData.append("name", name);
            formData.append("rid", regid);
            // Use jQuery AJAX to send the file to the server
            $.ajax({
                url: "inc/action.php", // Replace with your backend script URL
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    // Handle the response from the server (if needed)
                    alert(response);
                },
                error: function (xhr, status, error) {
                    // Handle errors (if any)
                    alert("Error uploading file. Status: " + xhr.status);
                }
            });
        } else {
            alert("Please select a file to upload.");
        }
    });
// UES TO FILTER TRACK BASE ON WHAT THE SCHOOL HAS TO OFFER REFER TO tblshsoffers
    $(document).on('change', '#inputSchool', function () {
        var sid = $(this).val();
        $.ajax({
            url: "inc/action.php",
            method: "POST",
            data: { schoolid: sid, action: 'trackList' },
            success: function (data) {
                $('#inputTrack').html(data);
                $('#inputStrand').html('<option value="">Choose Strand</option>');
            }
        })
    });

    $(document).on('change', '#inputTrack', function () {
        var sid = $('#inputSchool').val();
        var tid = $(this).val();
        $.ajax({
            url: "inc/action.php",
            method: "POST",
            data: { trackid: tid, schoolid: sid, action: 'strandList' },
            success: function (data) {
                $('#inputStrand').html(data);
            }
        })
    });
});
