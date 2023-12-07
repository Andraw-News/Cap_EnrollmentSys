<?php
session_start();
include 'funktion.php';
$action = new adminfunktion();
if(!empty($_GET['action']) && $_GET['action'] == 'logout') {
	session_unset();
	session_destroy();
	header("Location:../login.php");
}
//Account management
if(!empty($_POST['action']) && $_POST['action'] == 'accountList') {
	$action->getAccountList();
}
if(!empty($_POST['btn_action']) && $_POST['btn_action'] == 'accountAdd'){
	$action->saveAccount();
}
if(!empty($_POST['btn_action']) && $_POST['btn_action'] == 'getAccount'){
	$action->getAccount();
}
if(!empty($_POST['btn_action']) && $_POST['btn_action'] == 'viewAccount'){
	$action->viewAccountDetails();
}
if(!empty($_POST['btn_action']) && $_POST['btn_action'] == 'accountUpdate'){
	$action->updateAccount();
}
if(!empty($_POST['btn_action']) && $_POST['btn_action'] == 'accountDelete'){
	$action->deleteAccount();
}

// School management
if(!empty($_POST['action']) && $_POST['action'] == 'schoolList') {
	$action->getSchoolList();
}
if(!empty($_POST['btn_action']) && $_POST['btn_action'] == 'schoolAdd'){
	$action->saveSchool();
}
if(!empty($_POST['btn_action']) && $_POST['btn_action'] == 'getSchool'){
	$action->getSchool();
}
if(!empty($_POST['btn_action']) && $_POST['btn_action'] == 'schoolUpdate'){
	$action->updateSchool();
}
if(!empty($_POST['btn_action']) && $_POST['btn_action'] == 'schoolDelete'){
	$action->deleteSchool();
}

// Strand management
if(!empty($_POST['action']) && $_POST['action'] == 'strandList') {
	$action->getStrandList();
}
if(!empty($_POST['btn_action']) && $_POST['btn_action'] == 'strandAdd'){
	$action->saveStrand();
}
if(!empty($_POST['btn_action']) && $_POST['btn_action'] == 'getStrand'){
	$action->getStrand();
}
if(!empty($_POST['btn_action']) && $_POST['btn_action'] == 'strandUpdate'){
	$action->updateStrand();
}
if(!empty($_POST['btn_action']) && $_POST['btn_action'] == 'strandDelete'){
	$action->deleteStrand();
}

//Specialization Management
if(!empty($_POST['action']) && $_POST['action'] == 'SpecialSubjList') {
	$action->getSubjList();
}
if(!empty($_POST['btn_action']) && $_POST['btn_action'] == 'subjAdd'){
	$action->saveSubj();
}
if(!empty($_POST['btn_action']) && $_POST['btn_action'] == 'getSubj'){
	$action->getSubj();
}
if(!empty($_POST['btn_action']) && $_POST['btn_action'] == 'subjUpdate'){
	$action->updateSubj();
}
if(!empty($_POST['btn_action']) && $_POST['btn_action'] == 'subjDelete'){
	$action->deleteSubj();
}
?>