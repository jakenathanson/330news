<?php

require 'database.php';

$storyID = $_POST['thestoryid'];

echo($storyID);

$stmt = $mysqli->prepare("delete from stories where storyid=?");
$stmt->bind_param('i', $storyID);
$stmt->execute();
$stmt->close();

header('Location: home.php');

?>
