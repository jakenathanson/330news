<?php

require 'database.php';

$commentID = $_POST['commentid'];
$commentText = $_POST['newcomment'];

$stmt = $mysqli->prepare("update comments set text=? where commentid=?");
if (!$stmt) {
  printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('si', $commentText, $commentID);
$stmt->execute();
$stmt->close();

header('Location: storypage.php');

?>
