<!doctype html>
<html>

<?php
require 'database.php';
session_start();
$oldP = $_POST['oldPwd'];
$first = $_POST['NewPwd1'];
$second = $_POST['NewPwd2'];
$uid=$_SESSION['uid'];

if (!$uid||!$first||!$second) {
  header('Location: home.php');
}


if (((strcmp($first, $second))==0)) {

  $newname=$first;

  // update appropriate values in database
  $stmt = $mysqli->prepare("update users set username=? where uid=?");
  if (!$stmt) {
    printf("Query Prep Failed: %s\n", $mysqli->error);
  	exit;
  }
  $stmt->bind_param('si', $newname, $uid);
  $stmt->execute();
  $stmt->close();
  $_SESSION['user']=$newname;
  // redirect to poststory
  header('Location: home.php');

} else {

  echo("<script>alert(\"Your usernames did not match! Try again.\"); location=\"account.php\"</script>");


}

?>

</html>
