<!doctype html>
<html lang="en">
  <head>
    <link rel="stylesheet" type="text/css" href="main.css">
  </head>

  <ul>
    <?php
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

<?php session_start();
$uid=$_SESSION['uid'];?>

<body>


<div id="message">
<h1> Edit Your Story</h1>
Posting as <?php echo $_SESSION['user'];?>



</div>
  </p>
</div>


  <div id="post-story">
  <form action="edit-story-database.php" method="POST" id="story-post">
     <p>
        <h2> Title: </h2>
       <input type="text" name="title" id="title" value="<?php echo $_POST['title']; ?>" required/>
     </p>
     <p>
       <h2> Optional Link: </h2>
       <input type="text"value="<?php echo $_POST['link']; ?>" name="link" id="link"/>
     </p>
     <h2> Story goes here: </h2>
     <textarea rows="10" cols="100" name="body" form="story-post" required><?php echo $_POST['body'];?></textarea>
     <p>
       <input type="submit" value="Click to Update" style="position: fixed;
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
     <input type="hidden" name="storyid" value="<?php echo($_POST['storyid']); ?>">
   </form>
 </div>


</body>


</html>
