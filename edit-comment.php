<!doctype html>
<html>

<head>
  <title>Edit Comment</title>
</head>

<body>
  <div>
    <form action="edit-comment-database.php" method="post">
    <?php
    session_start();
    if(!empty($_POST)) {
    if(!hash_equals($_SESSION['token'], $_POST['token'])){
    	die("Request forgery detected");
    }
  }

    // simple form to get new comment text
    printf("<input type=\"text\" name=\"newcomment\" value=\"%s\">", $_POST['commentcontent']);
    printf("<input type=\"hidden\" name=\"commentid\" value=\"%d\">", $_POST['commentID']);
    printf("<input type=\"hidden\" name=\"token\" value=\"%s\">", $_SESSION['token']);

    ?>
    <input type="submit" name="submit">
  </form>
</div>
</body>

</html>
