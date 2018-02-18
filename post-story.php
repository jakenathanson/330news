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
Posting as <?php echo $_SESSION['user'];?>



  </p>
</div>


  <div id="post-story">
  <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
     <p>
       <label for="firstnameinput">Title:</label>
       <input type="text" name="title" id="title"/>
     </p>
     <p>
       <label for="firstnameinput">Optional Link:</label>
       <input type="text" name="link" id="link"/>
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
session_start();
 require 'database.php';

 $author=$_SESSION['user'];
 $authorid=$_SESSION['uid'];
 $date=date('l jS \of F Y h:i:s A');
 $body = $_POST['body'];
 $title = $_POST['title'];
 $link = $_POST['link'];
 $clicks=null;


 $stmt = $mysqli->prepare("insert into stories (author, authorid, date, body, title, clicks, link) values (?, ?, ?, ?, ?, ?,?)");
 if(!$stmt){
 	printf("Query Prep Failed: %s\n", $mysqli->error);
 	exit;
 }

 $stmt->bind_param('sisssis', $author, $authorid,$date,$body,$title,$clicks,$link);

 $stmt->execute();

 $stmt->close();
 ?>


</body>


</html>
