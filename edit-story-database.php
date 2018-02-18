<?php

require 'database.php';

$newTitle = $_POST['title'];
$newLink = $_POST['link'];
$newBody = $_POST['body'];
$storyID = $_POST['storyid'];

$stmt = $mysqli->prepare("update stories set title=?, link=?, body=? where storyid=?");
if (!$stmt) {
  printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('sssi', $newTitle, $newLink, $newBody, $storyID);
$stmt->execute();
$stmt->close();

header('Location: storypage.php');

?>
