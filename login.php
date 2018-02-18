<!doctype html>
<html lang="en">
  <head>
    <link rel="stylesheet" type="text/css" href="main.css">
  </head>

  <ul>
    <li style="float:left"><a class="active" href="#about">330news</a></li>
    <li style="float:right"><a class="active" href="register.php">Register</a></li>
    <li style="float:right"><a class="active" href="home.php">Home</a></li>
  </ul>


<body>


  <div id="message">
<h1> Welcome to the 330 News Site</h1>
<br>

Please Login If You Would Like To Post and Comment
  </p>




  <div id="loginbox">
  <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
     <p>
       <label for="firstnameinput">Username:</label>
       <input type="text" name="username" id="username"/>
     </p>
     <p>
       <label for="firstnameinput">Password:</label>
       <input type="Password" name="password" id="password"/>
     </p>
     <p>
       <input type="submit" value="Login" />
     </p>
   </form>
 </div>


 <?php
 error_reporting(0);
 session_start();
// This is a *good* example of how you can implement password-based user authentication in your web application.

require 'database.php';

// Use a prepared statement
$stmt = $mysqli->prepare("SELECT COUNT(*), uid, password FROM users WHERE username=?");

// Bind the parameter
$stmt->bind_param('s', $user);
$user = $_POST['username'];
$stmt->execute();

// Bind the results
$stmt->bind_result($cnt, $user_id, $pwd_hash);
$stmt->fetch();

$pwd_guess = $_POST['password'];
// Compare the submitted password to the actual password hash

if($cnt == 1 && password_verify($pwd_guess, $pwd_hash)){
	// Login succeeded!
	$_SESSION['uid'] = $user_id;
  $_SESSION['user'] = $user;
  $_SESSION['token']= bin2hex(openssl_random_pseudo_bytes(32));
  header ('Location: home.php');

} else{
	// Login failed; redirect back to the login screen
}
?>



</body>


</html>
