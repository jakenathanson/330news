<?php

session_start();
require 'database.php';
if(!empty($_POST)){
if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
}
}

$stmt = $mysqli->prepare("delete from comments where commentid=?");
$stmt->bind_param('i', $_POST['commentID']);
$stmt->execute();
$stmt->close();

header('Location: storypage.php');

?>
