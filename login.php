<?php 
ob_start();
session_start();
$loginError = '';
if (isset($_POST['signin'])) {
    if (!empty($_POST)) {
        include 'inc/funktion.php';
        $action = new funktion();
        $login = $action->login($_POST['email'], $_POST['password']); 
        if(!empty($login)) {
            $_SESSION['userid'] = $login[0]['account_id'];
            $_SESSION['schoolid'] = $login[0]['school_id'];
            if (empty($login[0]['school_id'])) {
                header("Location:admin/dashboard.php");
            } else {
                $school = $action->getSchool($login[0]['school_id']);
                $_SESSION['schoolname'] = $school[0]['name'];
                header("Location:registrar/dashboard.php");
            }			   
        } else {
                $loginError = "Invalid email or password!";
        }    
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css"
        integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600|Open+Sans:400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="css/easion.css">
    <script src="js/jquery-3.7.1.min.js"></script>
    <title>Login </title>
</head>

<body>
    <div class="form-screen">
        <a href="#!" class="easion-logo"><i class="fas fa-school"></i> <span>E-enroll</span></a>
        <div class="card account-dialog">
            <div class="card-header bg-primary text-white"> Login </div>
            <div class="card-body">
            <?php if ($loginError ) {?>
                <div class="alert alert-danger" role="alert"><?php echo $loginError; ?></div>
            <?php } ?>
                <form action="" method="POST">
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email" title="email">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password" title="password">
                    </div>
                    <div class="account-dialog-actions">
                        <button type="submit" class="btn btn-primary" name="signin" id="signin" title="Sign in">Sign in</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>