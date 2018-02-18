<?php

require 'database.php';

// set variables from php post
$newTitle = $_POST['title'];
$newLink = $_POST['link'];
$newBody = $_POST['body'];
$storyID = $_POST['storyid'];

// update appropriate values in database
$stmt = $mysqli->prepare("update stories set title=?, link=?, body=? where storyid=?");
if (!$stmt) {
  printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('sssi', $newTitle, $newLink, $newBody, $storyID);
$stmt->execute();
$stmt->close();

// redirect to the same story
header('Location: storypage.php');

?>
