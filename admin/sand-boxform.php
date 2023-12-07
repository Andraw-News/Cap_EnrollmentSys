<?php
ob_start();
session_start();
include 'funktion.php';
$action = new funktion();
include('include/header.php');
?>
        <script src="shscampus.js"></script>
    </head>
    <?php include('include/navigation.php');?>
        <div class="dash-app">
            <?php include('include/toolbar.php');?>
            <main class="dash-content">
                <div class="container-fluid">
                    <h2 class="dash-title">Registered Schools</h2>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card easion-card">
                                <div class="card-header">
                                    <div class="easion-card-icon">
                                        <i class="fas fa-plus"></i>
                                    </div>
                                    <div class="easion-card-title"> Add School </div>
                                </div>
                                <div class="card-body ">
                                    <form method="POST" id="schoolForm">
                                        <input type="hidden" name="btn_action" id="btn_action" value="schoolAdd">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>ID</label>
                                                <input type="number" name="schoolid" id="schoolid" class="form-control" placeholder="School ID" value="">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Code</label>
                                                <input type="text" name="code" id="code" class="form-control" placeholder="Code" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputAddress">Name</label>
                                            <input type="text" name="name" id="name" class="form-control" placeholder="School Name">
                                            </div>
                                            <div class="form-group">
                                                <label for="inputAddress">Description</label>
                                                <input type="text" name="description" id="description" class="form-control" placeholder="Description">
                                                </div>
                                        <div>
                                            <a href="shscampus_main.php" class="btn btn-secondary">Back</a>
                                            <button type="submit" id="action" name="action" class="btn btn-primary" form="schoolForm">Add</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <?php include('include/footer.php');?>
