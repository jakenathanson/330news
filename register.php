<!doctype html>
<html lang="en">
  <head>
    <link rel="stylesheet" type="text/css" href="main.css">
    <title>Register</title>
    <meta charset="UTF-8">
  </head>

  <?php

  session_destroy();
  session_start();
  $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));

  ?>





  <ul>
    <li style="float:left"><a class="active" href="#about">330news</a></li>
    <li style="float:right"><a class="active" href="#about">Register</a></li>
    <li style="float:right"><a class="active" href="#about">Login</a></li>
  </ul>

<div id="message">
<h1> Welcome to the 330 News Site</h1>
<br>
Please Register If You Would Like To Post Stories and Comment
<br>
<br>
Have an account?
<form action="login.php">
    <input type="submit" value="Go to Login" />
</form>


</div>


  <div id="loginbox">
  <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
     <p>
       Username:
       <input type="text" name="username" id="username"/>
       <?php
       printf("<input type=\"hidden\" name=\"token\" value=\"%s\">", $_SESSION['token']);
      ?>
     </p>
     <p>
       Password:
       <input type="Password" name="password" id="password"/>
     </p>

     <p>
       <input type="submit" value="Register" />
     </p>
   </form>
 </div>

 <?php
 //error_reporting(0);
 require 'database.php';
 if(!empty($_POST)) {
 if(!hash_equals($_SESSION['token'], $_POST['token'])){
   echo($_SESSION['token']);
   echo("<br><br>");
   echo($_POST['token']);
 	//die("Request forgery detected");
}}

 $user = $_POST['username'];
 $password = $_POST['password'];
 $hash=password_hash($password, PASSWORD_BCRYPT);

 $stmt = $mysqli->prepare("insert into users (username, password) values (?, ?)");
 if(!$stmt){
 	printf("Query Prep Failed: %s\n", $mysqli->error);
 	exit;
 }

 $stmt->bind_param('ss', $user, $hash);

 $stmt->execute();

 $stmt->close();
 ?>





</html>
