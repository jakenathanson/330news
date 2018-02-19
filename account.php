<!doctype html>
<html lang="en">
<head>
  <link rel="stylesheet" type="text/css" href="main.css">
  <title>Account</title>
  <meta charset="UTF-8">
</head>

<body>
  <ul>
    <?php


    session_start();

    // if visitor is logged in, show "home" and "logout" buttons
    if (isset($_SESSION['uid'])){
      echo '<li style="float:right; background-color: red;"><a class="active" href="destroy.php">Logout</a></li>';
      echo '<li style="float:right; background-color: green;"><a class="active" href="home.php">Home</a></li>';
    } else { // otherwise, they shouldent be here and need to go home
      header('Location: home.php');
    }
    ?>

    <li style="float:left"><a class="active" href="#about">330news</a></li>
  </ul>

  <div id="account_data">

    <div id="usernamechange">
      <h2> Current Username:<?php echo htmlentities($_SESSION['user']); ?> </h2>

      Change username
      <form action="changeusername.php" method="post" id="usernameform">
        New username: <input type="text" name="newUsername1" required><br>
        Confirm new username: <input type="text" name="newUsername2" required><br>
        <input type="submit" value="Go">
      </form>
      <br><br>
    </div>

    <div id="passwordchange">
      Change password
      <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post" id="pwdform">
        Old password: <input type="text" name="oldPwd" required><br>
        New password: <input type="password" name="newPwd1" required><br>
        Confirm new password: <input type="password" name="newPwd2" required><br>
        <input type="submit" value="Go">
      </form>
      <br><br>
    </div>

    <div id="emailchange">

      <h2> Current Email:<?php
      error_reporting(0);
      echo htmlentities($_SESSION['email']); ?> </h2>
      Update email address
      <form action="updateemail.php" method="post" id="emailform">
        New email address: <input type="email" name="newEmail1"><br>
        Confirm email address: <input type="email" name="newEmail2"><br>
        <input type="submit" value="go">
      </form>
    </div>

  </div>


<?php
// For infosec we decided to process passwords on same page
require 'database.php';
$oldP = $_POST['oldPwd'];
$first = $_POST['newPwd1'];
$second = $_POST['newPwd2'];
$uid=$_SESSION['uid'];

// Use a prepared statement
$stmt = $mysqli->prepare("SELECT COUNT(*), password FROM users WHERE uid=?");

// Bind the parameter
$stmt->bind_param('i', $uid);
$stmt->execute();

// Bind the results
$stmt->bind_result($cnt, $pwd_hash);
$stmt->fetch();
$stmt->close();

// Compare the submitted password to the old password
if($cnt == 1 && password_verify($oldP, $pwd_hash)){
  // Confirm user entered same new password
  if ((strcmp($first, $second) == 0)) {
    //update new pass
    $hash=password_hash($first, PASSWORD_BCRYPT);

    $nstmt = $mysqli->prepare("update users set password=? where uid=?");
    if(!$nstmt){
    	printf("Query Prep Failed: %s\n", $mysqli->error);
    	exit;
    }

    $nstmt->bind_param('si', $hash, $uid);

    $nstmt->execute();

    $nstmt->close();


    echo("<script>alert(\"PASSWORD UPDATED!\"); </script>");

  }
  else{ echo("<script>alert(\"Your New Passwords Don't Match. Try Again\"); </script>");
  }
}
else {
  if($oldP){
    echo("<script>alert(\"Your Old Password is incorrect. Try Again\"); </script>");
  }
}

?>


</body>
</html>
