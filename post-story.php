<!doctype html>
<html lang="en">
  <head>
    <link rel="stylesheet" type="text/css" href="main.css">
  </head>

  <ul>
    <?php
    error_reporting(0);
    session_start();
    if ($_SESSION['uid']){
      echo '<li style="float:right; background-color: red;"><a class="active" href="login.php">Logout</a></li>';
      echo '<li style="float:right; background-color: green;"><a class="active" href="home.php">Home</a></li>';
    } else {
      header ('Location: home.php');
    }
    ?>

    <li style="float:left"><a class="active" href="#about">330news</a></li>

  </ul>

<?php error_reporting(0); session_start();
$uid=$_SESSION['uid'];?>




<body>


<div id="message">
<h1> Post a Story</h1>
Posting as <?php echo $_SESSION['user'];?>



  </p>
</div>


  <div id="post-story">
  <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST" id="story-post">
     <p>
        <h2> Title: </h2>
       <input type="text" name="title" id="title" required/>
     </p>
     <p>
       <h2> Optional Link: </h2>
       <input type="text" name="link" id="link"/>
     </p>
     <h2> Story goes here: </h2>
     <textarea rows="10" cols="100" name="body" form="story-post" required></textarea>
     <p>
       <input type="submit" value="Click to Post" style="position: fixed;
       bottom: 0px;
       left: 0px;
       right: 0px;
       text-align: center;
       padding: 25px 50%;
       background-color: green;
       color: white;
       vertical-align: middle;

       "/>
     </p>

   </form>
 </div>

 <?php

 //error_reporting(0);

 require 'database.php';
 date_default_timezone_set('America/Chicago');


 $author=$_SESSION['user'];
 $authorid=$_SESSION['uid'];
 $date=date('m/d/Y');
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

 $stmt = $mysqli->prepare("select storyid from stories order by storyid desc limit 1");
 if(!$stmt){
 	printf("Query Prep Failed: %s\n", $mysqli->error);
 	exit;
 }
 $stmt->execute();
 $stmt->bind_result($lastRowID);
 $stmt->fetch();
 $stmt->close();

 $_SESSION['currStory'] = ($lastRowID + 1);
 echo("this is also a test");
 echo($lastRowID + 1);
 echo("this is a test");

 if (isset($_POST['body']) && isset($_POST['title'])) {
   header('Location: storypage.php');
 }

 ?>


</body>


</html>
