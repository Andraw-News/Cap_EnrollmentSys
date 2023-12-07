<?php
session_start();
include 'funktion.php';
$action = new funktion();
//Enrollment management
if(!empty($_POST['action']) && $_POST['action'] == 'saveDetails') {
	$action->saveRegForm();
}
if(!empty($_POST['action']) && $_POST['action'] == 'updateDetails') {
	$action->updateRegForm();
}
if(!empty($_POST['action']) && $_POST['action'] == 'getStudDetails') {
	$action->getDetails();
}
if(!empty($_POST['action']) && $_POST['action'] == 'getRegId') {
	echo $action->generateRegID();
}
if(!empty($_POST['action']) && $_POST['action'] == 'uploadsFile') {
	$action->uploadFile();
}
if(!empty($_POST['btn_action']) && $_POST['btn_action'] == 'getList'){
	$action->getList();
}
if(!empty($_POST['action']) && $_POST['action'] == 'trackList') {
	echo $action->trackDropdownList($_POST['schoolid']);
}
if(!empty($_POST['action']) && $_POST['action'] == 'strandList') {
	echo $action->strandDropdownList($_POST['trackid'],$_POST['schoolid']);
}
?>