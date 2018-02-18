<?php
// Content of database.php

$mysqli = new mysqli('localhost', 'server', 'RNJXTffZ3EcjD7bz', '330news');

if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}
?>
