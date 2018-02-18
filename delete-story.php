<?php
session_start();

require 'database.php';
if(!empty($_POST)){
if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
}
}

// get appropriate story id from php post
$storyID = $_POST['thestoryid'];

// delete story from the database
$stmt = $mysqli->prepare("delete from stories where storyid=?");
$stmt->bind_param('i', $storyID);
$stmt->execute();
$stmt->close();

// redirect to the homepage
header('Location: home.php');

?>
