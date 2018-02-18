<!doctype html>
<html>

<?php
date_default_timezone_set('America/Chicago');
session_start();
if(!hash_equals($_SESSION['token'], $_POST['token'])){
  die("Request forgery detected");
}

require 'database.php';

$upvotes = 0;
$downvotes = 0;

$commenterID = $_SESSION['uid'];
$storyID = $_POST['storyid'];
$text = $_POST['commenttext'];
$date = date('H:i:s \o\n m/d/Y');

$stmt = $mysqli->prepare("select username from users where uid=?");
if (!$stmt) {
  printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('i', $commenterID);
$stmt->execute();
$stmt->bind_result($username);
$stmt->fetch();
$stmt->close();

$stmt = $mysqli->prepare("insert into comments (commenter, commenterid, loc, stamp, upvotes, downvotes, text) values (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param('siisiis', $username, $commenterID, $storyID, $date, $upvotes, $downvotes, $text);
$stmt->execute();
$stmt->close();

header('Location: storypage.php');


?>
