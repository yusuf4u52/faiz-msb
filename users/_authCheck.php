<?php
include('connection.php');

// check if user didn't hit this page directly and is coming from login page
session_start();
if (!isset($_SESSION['fromLogin'])) {
 	header("Location: login.php");
 	exit;
}

// check if user has right to access the page
$rights = array(
	"musaid" => array("/users/musaid.php"),
	"superadmin" => array("/users/musaid.php",
		"/users/admin_scripts.php",
		"/users/stop_permanant.php",
		"/users/thalisearch.php"
	),
	"admin" => array("/users/musaid.php",
		"/users/admin_scripts.php",
		"/users/stop_permanant.php",
		"/users/thalisearch.php"
	),
	"all" => array("/users/index.php",
		"/users/hoobHistory.php",
		"/users/events.php",
		"/users/update_details.php",
		"/users/selectyearlyhub.php",
		"/users/selectyearlyhub_action.php")
);	
// fetch user role
$sql = mysqli_query($link,"SELECT role from users where email='".$_SESSION['email']."'");

$requet_path = explode('?',$_SERVER['REQUEST_URI'])[0];

if ($row = mysqli_fetch_assoc($sql)) {
	$_SESSION['role'] = $row['role'];
	if (!in_array($requet_path, $rights[$row['role']]) && !in_array($requet_path, $rights['all'])) {
		header("Location: index.php");
	}
} else if(!in_array($requet_path, $rights['all'])){
	echo "You are not an authorized user.";
	header("Location: index.php");
}
?>