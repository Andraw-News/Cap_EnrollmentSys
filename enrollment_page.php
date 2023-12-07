<?php
ob_start();
session_start();
include 'inc/funktion.php';
$action = new funktion();
include 'inc/header.php';
?>
<script src="js/enrollment.js"></script>
<style>
    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        font-family: Arial, Helvetica, sans-serif;
    }

    .topnav {
        overflow: hidden;
        background-color: #333;
    }

    .topnav a {
        float: left;
        color: #f2f2f2;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        font-size: 17px;
    }

    .topnav a:hover {
        background-color: #ddd;
        color: black;
    }

    .topnav a.active {
        background-color: #04AA6D;
        color: white;
    }
</style>
<title>Enrollment</title>
</head>

<body>
    <nav class="topnav">
        <a href="home.html">Home</a>
        <a class="active" href="enrollment_page.html">Enrollment</a>
        <a href="#about">About</a>
        <a href="login.php">Login</a>
    </nav>
    <main class="dash-content">
        <div class="container-fluid">
            <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header alert-success">
                            <h5 class="modal-title" id="staticBackdropLabel">Student Enrolled Successfully</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="msg">

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-3">
                    <div class="card rounded-lg">
                        <div class="card-body bg-warning text-dark text-center rounded-lg">
                            <h4 class="card-title">
                                <div class="icon">
                                    <i class="fas fa-info-circle"></i><span> Instruction</span>
                                </div>
                            </h4>
                            <i>All information in CAPITAL letters.</i>
                        </div>
                    </div>
                </div>
                <div class="col-xl-7 ">
                    <div class="card easion-card">
                        <div class="card-body ">
                            <div class="row">
                                <h4 class="card-title">
                                    <div class="icon">
                                        <i class="far fa-user-circle"></i><span> Student Type</span>
                                    </div>
                                </h4>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Student Type</label>
                                <div class="col-sm-3">
                                    <select id="inputSType" name="inputSType" class="form-control rounded-sm">
                                        <option selected="" value="">Choose Type</option>
                                        <option value="NEW">New Student</option>
                                        <option value="OLD">Old Student</option>
                                    </select>
                                </div>
                            </div>
                            <form method="POST" id="verifyID" hidden>
                                <div class="form-group">
                                    <label class="">Student ID</label>
                                    <div class="row">
                                        <div class="col-4">
                                            <input type="number" class="form-control rounded-sm" id="studId" name="studId" placeholder="Enter Student ID">
                                        </div>
                                        <div class="col">
                                            <button type="submit" class="btn btn-primary rounded-sm">Verify</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card easion-card regform">
                        <div class="card-header text-center">
                            <div class="easion-card-title ">
                                <h2>Pre Registration Form</h2>
                                <small class="form-text text-muted"> Academic Year: 2023 - 2024</small>
                            </div>
                        </div>

                        <form method="POST" id="regForm" name="regForm" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <input type="hidden" id="stype" name="stype">
                            <div class="card-body border-bottom">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label col-form-label-sm">Registration ID</label>
                                    <div class="col-sm-9">
                                        <input type="number" readonly class="form-control-sm form-control-plaintext" id="inputRegId" name="inputRegId" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="card-header bg-light">
                                <div class="easion-card-icon">
                                    <i class="fas fa-school"></i>
                                </div>
                                <div class="easion-card-title"> School </div>
                            </div>
                            <div class="card-body border-bottom">
                                <div class="form-group">
                                    <label>Schools</label>
                                    <select id="inputSchool" name="inputSchool" class="form-control rounded-sm">
                                        <option selected="" value="">Choose School</option>
                                        <?php echo $action->schoolDropdownList(); ?>
                                    </select>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Grade Level</label>
                                    <div class="col-sm-3">
                                        <select id="inputGrade" name="inputGrade" class="form-control rounded-sm">
                                            <option selected="" value="">Choose Level</option>
                                            <option value="11">Grade 11</option>
                                            <option value="12">Grade 12</option>
                                        </select>
                                    </div>
                                    <label class="col-sm-2 col-form-label">Semester</label>
                                    <div class="col-sm-4">
                                        <select id="inputSem" name="inputSem" class="form-control rounded-sm">
                                            <option selected="" value="">Choose Semester</option>
                                            <option value="1">1st</option>
                                            <option value="2">2nd</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card-header bg-light">
                                <div class="easion-card-icon">
                                    <i class="fas fa-user-edit"></i>
                                </div>
                                <div class="easion-card-title"> Student Information </div>
                            </div>
                            <div class="card-body border-bottom">
                                <div class="form-group ">
                                    <label>Learners Refernce No. (LRN)</label>
                                    <input type="number" id="inputLRN" name="inputLRN" class="form-control rounded-sm" placeholder="LRN" value="">
                                    <input type="hidden" id="studentid" name="studentid">
                                </div>
                                <div class="form-group">
                                    <label>Full Name</label>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <input type="text" id="inputLname" name="inputLname" class="form-control rounded-sm" placeholder="Last Name">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" id="inputFname" name="inputFname" class="form-control rounded-sm" placeholder="First Name">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" id="inputMname" name="inputMname" class="form-control rounded-sm" placeholder="Middle Name">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label>Date of Birth</label>
                                        <input type="date" id="inputBDate" name="inputBDate" class="form-control rounded-sm">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Birth Place</label>
                                        <input type="text" id="inputBPlace" name="inputBPlace" class="form-control rounded-sm" placeholder="Municipality / City">
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label>Email Address</label>
                                        <input type="email" id="inputEmail" name="inputEmail" class="form-control rounded-sm" placeholder="example@email.com">
                                    </div>
                                </div>
                                <fieldset class="form-group">
                                    <div class="row">
                                        <legend class="col-form-label col-sm-2">Sex</legend>
                                        <div class="col-sm-4">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inputGender" id="inlineRadio1" value="male">
                                                <label class="form-check-label">Male</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inputGender" id="inlineRadio2" value="female">
                                                <label class="form-check-label">Female</label>
                                            </div>
                                        </div>
                                        <label class="col-sm-2 col-form-label">Age</label>
                                        <div class="col-sm-3">
                                            <input type="number" id="inputAge" name="inputAge" class="form-control rounded-sm" placeholder="Age" value="">
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="form-group">
                                    <label> Current Address</label>
                                    <input type="text" id="caddr" name="caddr" class="form-control rounded-sm" placeholder="House Number, Street, Baranggay, City, Province">
                                </div>
                                <div class="form-group">
                                    <label> Home Address</label>
                                    <small class="form-text text-muted">
                                        Same with your current address?
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" id="sameaddr" class="form-check-input">
                                            <label class="form-check-label">Yes</label>
                                        </div>
                                    </small>
                                    <input type="text" id="haddr" name="haddr" class="form-control" placeholder="House Number, Street, Baranggay, City, Province">
                                </div>
                            </div>
                            <div class="card-header bg-light">
                                <div class="easion-card-icon">
                                    <i class="fas fa-user-friends"></i>
                                </div>
                                <div class="easion-card-title"> Parent's / Guardian's Information </div>
                            </div>
                            <div class="card-body border-bottom">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Father's Name</label>
                                        <input type="text" id="inputPFname" name="inputPFname" class="form-control rounded-sm" placeholder="Last Name, First Name / Middle Name">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Contact No.</label>
                                        <input type="tel" id="inputPFcontact" name="inputPFcontact" class="form-control rounded-sm" placeholder="+63 0 123 4567">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Mother's Name</label>
                                        <input type="text" id="inputPMname" name="inputPMname" class="form-control rounded-sm" placeholder="Last Name, First Name / Middle Name">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Contact No.</label>
                                        <input type="tel" id="inputPMcontact" name="inputPMcontact" class="form-control rounded-sm" placeholder="+63 0 123 4567">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Guardian's Name</label>
                                        <input type="text" id="inputGname" name="inputGname" class="form-control rounded-sm" placeholder="Last Name, First Name / Middle Name">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Contact No.</label>
                                        <input type="tel" id="inputGcontact" name="inputGcontact" class="form-control rounded-sm" placeholder="+63 0 123 4567">
                                    </div>
                                </div>
                            </div>
                            <div class="card-header bg-light">
                                <div class="easion-card-title"> Course </div>
                            </div>
                            <div class="card-body border-bottom">
                                <div class="form-group">
                                    <label>Tracks</label>
                                    <select id="inputTrack" name="inputTrack" class="form-control rounded-sm">
                                        <option selected="" value="">Choose Track</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Strands</label>
                                    <select id="inputStrand" name="inputStrand" class="form-control rounded-sm">
                                        <option selected="" value="">Choose Strand</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-header bg-light">
                                <div class="easion-card-title"> Enrollment Requirement </div>
                            </div>
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label> NSO/PSA Certified Birth Certificate </label>
                                            <input type="file" id="reqDocu" name="birthCert" class="form-control-file">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label>Original SF9 (Card)</label>
                                            <input type="file" id="reqDocu" name="SF9card" class="form-control-file">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label>JHS Completion Certificate (Grade 10 Diploma)</label>
                                            <input type="file" id="reqDocu" name="G10Diploma" class="form-control-file">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="action" name="action" value="saveDetails">
                        </form>
                        <div class="row">
                            <div class="col">
                                <hr>
                            </div>
                        </div>
                        <div class="card-body align-middle text-center">
                            <button type="submit" class="btn btn-primary btn-lg rounded-lg" form="regForm">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
            <footer>All Rights Reserved 2023</footer>
        </div>
    </main>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/easion.js"></script>
</body>

</html>