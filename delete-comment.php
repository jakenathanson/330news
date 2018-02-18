<?php

require 'database.php';

$stmt = $mysqli->prepare("delete from comments where commentid=?");
$stmt->bind_param('i', $_POST['commentID']);
$stmt->execute();
$stmt->close();

header('Location: storypage.php');

?>
