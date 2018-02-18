<!doctype html>
<html>

<?php
require 'database.php';
session_start();
$first = $_POST['newEmail1'];
$second = $_POST['newEmail1'];
$uid=$_SESSION['uid'];

if (!$uid||!$first||!$second) {
  header('Location: home.php');
}


if (((strcmp($first, $second))==0)) {

  $mail=$first;

  // update appropriate values in database
  $stmt = $mysqli->prepare("update users set email=? where uid=?");
  if (!$stmt) {
    printf("Query Prep Failed: %s\n", $mysqli->error);
  	exit;
  }
  $stmt->bind_param('si', $mail, $uid);
  $stmt->execute();
  $stmt->close();
  $_SESSION['email']=$mail;
  // redirect to poststory
  header('Location: account.php');

} else {

  echo("<script>alert(\"Your emails did not match! Try again.\"); location=\"account.php\"</script>");


}

?>

</html>
