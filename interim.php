<?php
session_start();

$storyID = $_GET['id'];
/*echo("<form action=\"storypage.php\" method=\"post\">");
printf("<input type=\"hidden\" name=\")*/
$_SESSION['currStory'] = $storyID;

header('Location: storypage.php');

?>
