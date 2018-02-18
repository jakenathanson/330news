<!doctype html>
<html lang="en">
  <head>
    <link rel="stylesheet" type="text/css" href="main.css">
  </head>

  <ul>
    <li style="float:left"><a class="active" href="#about">330news</a></li>
    <li style="float:right"><a class="active" href="#about">Register</a></li>
    <li style="float:right"><a class="active" href="#about">Login</a></li>
  </ul>



// infosec

<?php session_start();
$uid=$_SESSION['uid'];?>

// end infosec



<body>


<div id="message">
<h1> Post a Story</h1>
Posting as <?php echo $var ?>



  </p>
</div>


  <div id="post-story">
  <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
     <p>
       <label for="firstnameinput">Title:</label>
       <input type="text" name="username" id="username"/>
     </p>
     <p>
       <label for="firstnameinput">Body:</label>
       <input type="text" name="body" id="body"/>
     </p>

     <p>
       <input type="submit" value="Post" />
     </p>
   </form>
 </div>

 <?php
 require 'database.php';
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


</body>


</html>
