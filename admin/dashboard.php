<?php
ob_start();
session_start();
include 'funktion.php';
$action = new adminfunktion();
$action->checkLogin();
include('include/header.php');
?>
        
    </head>
    <body>
        <div class="dash">
            <?php include('include/navigation.php');?>
                <div class="dash-app">
                    <?php include('include/toolbar.php');?>
                    <main class="dash-content">
                        <div class="container-fluid">
                            <div class="row dash-row">
                                <div class="col-xl-4">
                                    <div class="stats stats-primary">
                                        <h3 class="stats-title"> Registrar Accounts </h3>
                                        <div class="stats-content">
                                            <div class="stats-icon">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div class="stats-data">
                                                <div class="stats-number"><?php echo $action->registrarCount();?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="stats stats-success ">
                                        <h3 class="stats-title"> Registered Schools </h3>
                                        <div class="stats-content">
                                            <div class="stats-icon">
                                                <i class="fas fa-cart-arrow-down"></i>
                                            </div>
                                            <div class="stats-data">
                                                <div class="stats-number"><?php echo $action->schoolCount();?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="stats stats-info">
                                        <h3 class="stats-title"> Strands </h3>
                                        <div class="stats-content">
                                            <div class="stats-icon">
                                                <i class="fas fa-phone"></i>
                                            </div>
                                            <div class="stats-data">
                                                <div class="stats-number"><?php echo $action->ssubjectsCount();?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </div>
        <?php include('include/footer.php');?>