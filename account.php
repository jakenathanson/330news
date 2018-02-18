<!doctype html>
<html lang="en">
<head>
  <link rel="stylesheet" type="text/css" href="main.css">
</head>

<body>
  <ul>
    <?php


    session_start();

    // if visitor is logged in, show "post story" and "logout" buttons
    if (isset($_SESSION['uid'])){
      echo '<li style="float:right; background-color: red;"><a class="active" href="destroy.php">Logout</a></li>';
      echo '<li style="float:right; background-color: green;"><a class="active" href="home.php">Home</a></li>';
    } else { // otherwise, show "login" and "register"
      header('Location: home.php');
    }
    ?>

    <li style="float:left"><a class="active" href="#about">330news</a></li>
  </ul>

  <div id="account_data">

    <div id="usernamechange">
      <h2> Current Username:<?php echo $_SESSION['user'] ?> </h2>

      Change username
      <form action="changeusername.php" method="post" id="usernameform">
        <label for="newName">New username: </label><input type="text" name="newUsername1" required><br>
        <label for="newNameConfirm">Confirm new username: </label><input type="text" name="newUsername2" required><br>
        <input type="submit" value="Go">
      </form>
      <br><br>
    </div>

    <div id="passwordchange">
      Change password
      <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post" id="pwdform">
        <label for="oldPwd">Old password: </label><input type="text" name="oldPwd" required><br>
        <label for="newPwd1">New password: </label><input type="password" name="newPwd1" required><br>
        <label for="newNameConfirm">Confirm new password: </label><input type="password" name="newPwd2" required><br>
        <input type="submit" value="Go">
      </form>
      <br><br>
    </div>

    <div id="emailchange">
      Update email address
      <form action="updateemail.php" method="post" id="emailform">
        <label for="newEmail1">New email address: </label><input type="email" name="newEmail1"><br>
        <label for="newEmail1">Confirm email address: </label><input type="email" name="newEmail2"><br>
        <input type="submit" value="go">
      </form>
    </div>

  </div>
</div>

<?php
// For infosec we decided to process passwords on same page
require 'database.php';
$oldP = $_POST['oldPwd'];
$first = $_POST['NewPwd1'];
$second = $_POST['NewPwd2'];
$uid=$_SESSION['uid'];

// Use a prepared statement
$stmt = $mysqli->prepare("SELECT COUNT(*), password FROM users WHERE uid=?");

// Bind the parameter
$stmt->bind_param('i', $uid);
$stmt->execute();

// Bind the results
$stmt->bind_result($cnt, $pwd_hash);
$stmt->fetch();

// Compare the submitted password to the old password
if($cnt == 1 && password_verify($oldP, $pwd_hash)){
  // Confirm user entered same new password
  if ((strcmp($first, $second) == 0)) {





  }
  else{

echo("<script>alert(\"Your New Passwords Don't Match. Try Again\"); </script>");}

  }

  echo "working";
}
else {
  if($oldP){
    echo("<script>alert(\"Your Old Password is incorrect. Try Again\"); </script>");}
}




?>


</body>
</html>
