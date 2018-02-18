<!doctype html>
<html>

<?php
date_default_timezone_set('America/Chicago');
session_start();

$commenterID = $_SESSION['uid'];
$storyID = $_POST['storyid'];
$text = $_POST['commenttext'];
$date = date('H:i:s \o\n d/m/Y');

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
$stmt->bind_param('siisiis', $username, $commenterID, )


?>
