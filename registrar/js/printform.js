$(document).ready(function () {
        var id = 238845;
        var sid = 342242;
        var action = 'getAll';
        $.ajax({
            url: "action.php",
            method: "POST",
            data: { id: id, schoolid: sid, action: action },
            dataType: "json",
            success: function (data) {
                $('#SY').val(data.AY);
                $('#School').val(data.name);
                $('#studid').val(id);
                $('#regid').val(data.reg_id);
                $('#LRN').val(data.LRN);
                $('#Lname').val(data.stud_Lname);
                $('#Fname').val(data.stud_Fname);
                $('#Mname').val(data.stud_Mname);
                $('#BDate').val(data.BirthDate);
                $('#BPlace').val(data.BirthPlace);
                $('#Age').val(data.Age);
                $('#Email').val(data.stud_email);
                $('#caddr').val(data.Current_Address);
                $('#haddr').val(data.Home_Address);
                $('#PFname').val(data.ParentFname);
                $('#PFcontact').val(data.ParentFContact);
                $('#PMname').val(data.ParentMname);
                $('#PMcontact').val(data.ParentMContact);
                $('#Gname').val(data.GuardianName);
                $('#Gcontact').val(data.GuardianContact);
                $('#Grade').val(data.grade_lvl);
                $('#Track').val(data.track_descript);
                $('#Strand').val(data.strand_name+" - "+data.specialization_name);
                $("#QRimg").attr("src",data.qr_filepath);
                $('input[name="gender"][value="' + data.gender + '"]').prop('checked', true);
                $('input[name="sem"][value="' + data.semester + '"]').prop('checked', true);
                window.print();
            }
        })
    });
