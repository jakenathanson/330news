<!doctype html>
<html lang="en">
<head>
  <link rel="stylesheet" type="text/css" href="main.css">
</head>

<body>
  <ul>
    <?php


    session_start();



    if (!empty($_POST)) {
      if(!hash_equals($_SESSION['token'], $_POST['token'])){
      	die("Request forgery detected");
      }
    }

    // if visitor is logged in, show "post story" and "logout" buttons
    if (isset($_SESSION['uid'])){
      echo '<li style="float:right; background-color: red;"><a class="active" href="destroy.php">Logout</a></li>';
      echo '<li style="float:right; background-color: green;"><a class="active" href="post-story.php">Post a Story</a></li>';
      echo '<li style="float:right; background-color: yellow;"><a class="active" href="account.php"> My Account</a></li>';
    } else { // otherwise, show "login" and "register"
      echo'<li style="float:right; background-color: green;"" ><a class="active" href="register.php">Register</a></li>';
      echo'<li style="float:right; background-color: green;"" ><a class="active" href="login.php">Login</a></li>';
      $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
    }
    ?>

    <li style="float:left"><a class="active" href="#about">330news</a></li>
  </ul>

  <div id="storytable">

    <?php
    echo '<table style="width:100%">';
    echo "<tr>";
    echo "<th>Title</th>";
    echo "<th>Author</th>";
    echo "<th>Actions</th>";
    echo "</tr>";

    require 'database.php';

    // get UI contents of 'stories' table
    $stmt = $mysqli->prepare("select storyid, title, author from stories");
    if(!$stmt){
      printf("Query Prep Failed: %s\n", $mysqli->error);
      exit;
    }
    $stmt->execute();

    // bind result, use array for display purposes
    $result = $stmt->get_result();

    // iteratively generate html table with database contents
    while($row = $result->fetch_assoc()){
      echo "<tr>";
      printf("<td>%s</td>",$row["title"]);
      printf("<td>%s</td>",$row["author"]);
      // create form for viewing stories (storyid passed as post)
      echo "<td><form action=\"storypage.php\" method=\"post\">";
      echo "<input type=\"submit\" name=\"storyid\" value=\"Read\"/>";
      printf("<input type=\"hidden\" name=\"storyid\" value=\"%s\">",$row["storyid"] );
      printf("<input type=\"hidden\" name=\"token\" value=\"%s\">", $_SESSION['token']);
      echo "</form>";
      if (isset($_SESSION['uid'])) {
      echo "<form action=\"save_share.php\" method=\"post\">";
      echo "<input type=\"submit\" name=\"storyid\" value=\"Share\"/>";
      printf("<input type=\"hidden\" name=\"whatAction\" value=\"share\">");
      printf("<input type=\"hidden\" name=\"storyid\" value=\"%s\">",$row["storyid"]);
      printf("<input type=\"hidden\" name=\"token\" value=\"%s\">", $_SESSION['token']);
      echo "</form>";
      echo "<form action=\"save_share.php\" method=\"post\">";
      echo "<input type=\"submit\" name=\"storyid\" value=\"Save for Later\"/>";
      printf("<input type=\"hidden\" name=\"whatAction\" value=\"save\">");
      printf("<input type=\"hidden\" name=\"storyid\" value=\"%s\">",$row["storyid"]);
      printf("<input type=\"hidden\" name=\"token\" value=\"%s\">", $_SESSION['token']);
      echo "</form>";
    }
      echo "</td></tr>";
    }
    echo "</table>";

    $stmt->close();
    ?>
  </div>

</body>
</html>
