<?php
ob_start();
session_start();
include 'funktion.php';
$action = new adminfunktion();
$action->checkLogin();
include('include/header.php');
?>
        <script src="js/specialization.js"></script>
    </head>
    <body>
        <div class="dash">
            <?php include('include/navigation.php');?>
                <div class="dash-app">
                    <?php include('include/toolbar.php');?>
                    <main class="dash-content">
                        <div class="container-fluid">
                            <h2 class="dash-title">Registered Track </h2>
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card easion-card">
                                        <div class="card-header">
                                            <div class="easion-card-icon">
                                                <i class="fas fa-list-ul"></i>
                                            </div>
                                            <div class="easion-card-title"> List of Specializations </div>
                                            <div class="easion-card-menu">
                                                <button name="add" id="addSubj" class="btn btn-primary btn-sm mb-1" data-toggle="modal" data-target="#strandModal">
                                                    <i class="fas fa-plus mr-2"></i> Add Specialization </button>
                                            </div>
                                        </div>
                                        <div class="card-body ">
                                            <table class="table table-striped table-in-card display nowrap" id="specialSubjList" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">ID</th>
                                                        <th scope="col">Strand</th>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="subjModal" tabindex="-1" role="dialog" aria-labelledby="subjModal" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="subjModal"><i class="fas fa-plus mr-2"></i> Add Strand</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" id="subjForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                                                <input type="hidden" name="id" id="id">
                                                <input type="hidden" name="btn_action" id="btn_action" value="subjAdd">
                                                <div class="form-group">
                                                    <label>Strand</label>
                                                    <select name="strandid" id="strandid" class="form-control">
                                                        <option value="">Choose Strand</option>
                                                        <?php echo $action->strandDropdownList(); ?>    
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Name</label>
                                                    <input type="text" name="name" id="name" class="form-control" placeholder="Name">
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" name="action" id="action" class="btn btn-primary" form="subjForm">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </div>
    <?php include('include/footer.php');?>