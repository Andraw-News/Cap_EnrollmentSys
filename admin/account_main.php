<?php
ob_start();
session_start();
include 'funktion.php';
$action = new adminfunktion();
$action->checkLogin();
include('include/header.php');
?>
        <script src="js/account.js"></script>
    </head>
    <body>
        <div class="dash">
            <?php include('include/navigation.php');?>
                <div class="dash-app">
                    <?php include('include/toolbar.php');?>
                    <main class="dash-content">
                        <div class="container-fluid">
                            <input type="hidden" name="acctype" id="acctype" value="registrar" form="accountForm">
                            <h2 class="dash-title align-middle text-center">Registered Accounts</h2>
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card easion-card">
                                        <div class="card-header">
                                            <div class="easion-card-icon">
                                                <i class="fas fa-list-ul"></i>
                                            </div>
                                            <div class="easion-card-title"> List of Accounts </div>
                                            <div class="easion-card-menu">
                                                <button name="add" id="addAccount" class="btn btn-primary btn-sm mb-1" data-toggle="modal" data-target="#accountModal">
                                                    <i class="fas fa-plus mr-2"></i> Add Account </button>
                                            </div>
                                        </div>
                                        <div class="card-body ">
                                            <table class="table table-responsive-xl table-striped" id="accountList" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">ID</th>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">School</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="accountModal" tabindex="-1" role="dialog" aria-labelledby="accountModal"aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="accountModal"><i class="fas fa-plus mr-2"></i> Add Strand</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" id="accountForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                                                <input type="hidden" name="id" id="id" />
                                                <input type="hidden" name="btn_action" id="btn_action" value="accountAdd">
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label>Name</label>
                                                        <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>Email</label>
                                                        <input type="email" name="email" id="email" class="form-control" placeholder="Email" value="">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>School</label>
                                                    <select name="schoolid" id="schoolid" class="form-control">
                                                        <option selected="">Choose School</option>
                                                        <?php echo $action->schoolDropdownList(); ?> 
                                                    </select>
                                                </div>
                                                <div class="form-row pass_field">
                                                    <div class="form-group col-md-6">
                                                        <label>Password</label>
                                                        <input type="password" name="password" id="password" class="form-control" placeholder="Password" value="">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>Confirm Password</label>
                                                        <input type="password" name="cpassword" id="cpassword" class="form-control" placeholder="Confirm Password" value="">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" name="action" id="action" class="btn btn-primary" form="accountForm">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="accountViewModal" tabindex="-1" role="dialog" aria-labelledby="accountviewModal" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="accountviewModal"><i class="fas fa-list-ul mr-2"></i> Account Details</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body" id="accountDetails">   
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </div>
    <?php include('include/footer.php');?>