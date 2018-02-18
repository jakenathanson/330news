<?php
require 'database.php';
session_start();

$stmt = $mysqli->prepare("select username from users where uid=?");
if(!$stmt){
 printf("Query Prep Failed: %s\n", $mysqli->error);
 exit;
}
$stmt->bind_param('i', $_SESSION['uid']);
$stmt->execute();
$stmt->bind_result($user);
$stmt->fetch();
$stmt->close();

$stmt = $mysqli->prepare("select title from stories where storyid=?");
if(!$stmt){
 printf("Query Prep Failed: %s\n", $mysqli->error);
 exit;
}
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($storyName);
$stmt->fetch();
$stmt->close();

$link = $_POST['link'];
$emailAddress = $_POST['emailaddress'];
$subject = $user . " has shared a story with you!";
$body = "Title: " . $storyName . "\n\nLink to story:\n" . $link;

mail($emailAddress, $subject, $body);

header('Location: home.php');

?>
