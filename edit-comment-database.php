<?php

require 'database.php';
if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
}

// startsWith function borrowed from https://stackoverflow.com/questions/9047603/php-string-comapre-with-wildcard
// credit to stackoverflow user MitMaro
function startsWith($haystack, $needle, $caseInsensitive = false) {
  if ($caseInsensitive){
    return (strcasecmp(substr($haystack, 0, strlen($needle)), $needle) === 0);
  }
  return (strcmp(substr($haystack, 0, strlen($needle)), $needle) === 0);
}

// get comment ID from post; get comment text for form population
$commentID = $_POST['commentid'];
$commentText = $_POST['newcomment'];

// if not already edited, append comment with '[Edit]' for records
if (!startsWith($commentText, "[Edit]", true)) {
  $commentText = "[Edit] " . $commentText;
}

// update database with new text
$stmt = $mysqli->prepare("update comments set text=? where commentid=?");
if (!$stmt) {
  printf("Query Prep Failed: %s\n", $mysqli->error);
  exit;
}
$stmt->bind_param('si', $commentText, $commentID);
$stmt->execute();
$stmt->close();

// redirect to the story page
header('Location: storypage.php');

?>
