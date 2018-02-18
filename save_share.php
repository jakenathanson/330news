<!doctype html>
<html>

<?php
session_start();
if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
}

$id = $_POST['storyid'];
$action = $_POST['whatAction'];
$link = "http://ec2-18-219-35-131.us-east-2.compute.amazonaws.com/~rfreret/330-News/interim.php?id=" . $id;

if (strcmp($action, "save") == 0) {
  if (isset($_SESSION['email'])) {
    mail($_SESSION['email'], 'Saved Article', $link);
  } else {
    echo("<script>alert(\"No user email address set! Add an email address in your account settings to save stories.\"); location=\"home.php\";</script>");
  }
} else if (strcmp($action, "share") == 0) {
  echo("<form action=\"share.php\" method=\"post\">");
  printf("<input type=\"text\" name=\"emailaddress\">");
  printf("<input type=\"hidden\" name=\"id\" value=\"%s\">", $id);
  printf("<input type=\"hidden\" name=\"link\" value=\"%s\">", $link);
  printf("<input type=\"hidden\" name=\"token\" value=\"%s\">", $_SESSION['token']);
  echo("<input type=\"submit\" value=\"Share\"></form>");
}

?>

</html>
