<!doctype html>
<html lang="en">
  <head>
    <link rel="stylesheet" type="text/css" href="main.css">
    <title>Post Story</title>
    <meta charset="UTF-8">
  </head>




<body>


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


<div id="message">
<h1> Post a Story</h1>
Posting as <?php echo $_SESSION['user'];?>



  
</div>


  <div id="post-story">
  <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST" id="story-post">

        <h2> Title: </h2>
       <input type="text" name="title" id="title" required/>
       <?php
       session_start();
       printf("<input type=\"hidden\" name=\"token\" value=\"%s\">", $_SESSION['token']);
      ?>


       <h2> Optional Link:  Must be "https://"</h2>
       <input type="text" name="link" id="link"/>

     <h2> Story goes here: </h2>
     <textarea rows="10" cols="100" name="body" form="story-post" required></textarea>

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


   </form>
 </div>

 <?php

 //error_reporting(0);

 require 'database.php';
 date_default_timezone_set('America/Chicago');
 if(!empty($_POST)) {
 if(!hash_equals($_SESSION['token'], $_POST['token'])){
 	die("Request forgery detected");
 }
}


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

 $stmt = $mysqli->prepare("select max(storyid) from stories where authorid=? limit 1");
 if(!$stmt){
 	printf("Query Prep Failed: %s\n", $mysqli->error);
 	exit;
 }
 $stmt->bind_param('i', $authorid);
 $stmt->execute();
 $stmt->bind_result($lastRowID);
 $stmt->fetch();
 $stmt->close();
 echo($lastRowID);

 $_SESSION['currStory'] = ($lastRowID);
 if (!empty($_POST['title']) && !empty($_POST['body'])) {
 header('Location: storypage.php');
}

 ?>


</body>


</html>
