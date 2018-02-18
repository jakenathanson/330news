<!doctype html>
<html>

<?php
require 'database.php';

$first = $_POST['newUsername1'];
$second = $_POST['newUsername2'];

if (!((strcmp($first, $second))==0)) {
  echo("<script>alert(\"Your usernames did not match! Try again.\")")
}

?>

</html>
