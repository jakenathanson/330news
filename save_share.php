<!doctype html>
<html>

<?php
session_start();

$id = $_POST['storyid'];
$action = $_POST['whatAction'];
$link = "http://ec2-18-219-35-131.us-east-2.compute.amazonaws.com/~rfreret/330-News/interim.php?id=" . $id;

if (strcmp($action, "save") == 0) {
  if (isset($_SESSION['emailaddress'])) {
    mail($_SESSION['emailaddress'], 'Saved Article', $link);
  } else {
    echo("<script>alert(\"No user email address set! Add an email address in your account settings to save stories.\")</script>");
  }
} else if (strcmp($action, "share") == 0) {
  echo("<form action=\"share.php\" method=\"post\">");
  printf("<input type=\"text\" name=\"emailaddress\">");
  printf("<input type=\"hidden\" name=\"id\" value=\"%s\">", $id);
  printf("<input type=\"hidden\" name=\"link\" value=\"%s\">", $link);
  echo("<input type=\"submit\" value=\"Share\"></form>");
}

?>

</html>
