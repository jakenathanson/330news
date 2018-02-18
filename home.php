<!doctype html>
<html lang="en">
  <head>
    <link rel="stylesheet" type="text/css" href="main.css">
  </head>

<body>
<ul>
  <?php


  session_start();
  if ($_SESSION['uid']){
    echo '<li style="float:right; background-color: red;"><a class="active" href="login.php">Logout</a></li>';
  } else {
    echo'<li style="float:right; background-color: green;"" ><a class="active" href="register.php">Register</a></li>';
    echo'<li style="float:right; background-color: green;"" ><a class="active" href="login.php">Login</a></li>';
  }

  ?>
  <li style="float:left"><a class="active" href="#about">330news</a></li>
</ul>
</body>
</html>
