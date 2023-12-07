<?php
ob_start();
session_start();
include 'regfunktion.php';
$action = new Regfunktion();
include('include/header.php');
?>
    </head>
    <?php include('include/navigation.php');?>
        <div class="dash-app">
            <?php include('include/toolbar.php');?>
            <main class="dash-content">
                <div class="container-fluid">
                <h1 class="dash-title">Blank</h1>
                    <!-- put your rows / columns here -->
                </div>
            </main>
        </div>
    </div>
    <?php include('include/footer.php');?>