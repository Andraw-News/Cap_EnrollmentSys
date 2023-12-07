<?php
session_start();
include 'regfunktion.php';
$action = new Regfunktion();
if(!empty($_GET['action']) && $_GET['action'] == 'logout') {
	session_unset();
	session_destroy();
	header("Location:../login.php");
}
// Student Info Management
if(!empty($_POST['action']) && $_POST['action'] == 'trackList') {
	echo $action->trackList($_POST['schoolid']);
}
if(!empty($_POST['action']) && $_POST['action'] == 'strandList') {
	echo $action->strandList($_POST['trackid'],$_POST['schoolid']);
}
if(!empty($_POST['action']) && $_POST['action'] == 'studentList') {
	$action->getStudentList();
}
if(!empty($_POST['btn_action']) && $_POST['btn_action'] == 'viewStudent'){
	$action->viewStudentDetails();
}
if(!empty($_POST['btn_action']) && $_POST['btn_action'] == 'getStudent'){
	$action->getStudent();
}
if(!empty($_POST['btn_action']) && $_POST['btn_action'] == 'getList'){
	$action->getList();
}
if(!empty($_POST['btn_action']) && $_POST['btn_action'] == 'studentUpdate'){
	$action->updateStudent();
}
if(!empty($_POST['btn_action']) && $_POST['btn_action'] == 'studentDelete'){
	$action->dropStudent();
}
if(!empty($_POST['btn_action']) && $_POST['btn_action'] == 'setStatus'){
	$action->setStats();
}

// Document and QR Management
if(!empty($_POST['action']) && $_POST['action'] == 'studentQRList') {
	$action->getStudentQRList();
}
if(!empty($_POST['btn_action']) && $_POST['btn_action'] == 'generateQR'){
	$action->generateQRCode();
}
if(!empty($_POST['btn_action']) && $_POST['btn_action'] == 'getRegForm'){
	$action->viewStudentform();
}
if(!empty($_POST['action']) && $_POST['action'] == 'getDocuList') {
	$action->StudentDocuList();
}

// Offered Courses Management
if(!empty($_POST['action']) && $_POST['action'] == 'courseList') {
	$action->getCourseList();
}
if(!empty($_POST['action']) && $_POST['action'] == 'spclList') {
	echo $action->courseDropdownList($_POST['strandid']);
}
if(!empty($_POST['btn_action']) && $_POST['btn_action'] == 'courseAdd'){
	$action->saveCourse();
}
if(!empty($_POST['btn_action']) && $_POST['btn_action'] == 'getCourse'){
	$action->getCourse();
}
if(!empty($_POST['btn_action']) && $_POST['btn_action'] == 'courseUpdate'){
	$action->updateCourse();
}
if(!empty($_POST['btn_action']) && $_POST['btn_action'] == 'courseDelete'){
	$action->deleteCourse();
}
?>