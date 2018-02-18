<!doctype html>
<html>

<head>
  <title>Edit Comment</title>
</head>

<body>
  <div>
    <form action="edit-comment-database.php" method="post">
    <?php

    printf("<input type=\"text\" name=\"newcomment\" value=\"%s\">", $_POST['commentcontent']);
    printf("<input type=\"hidden\" name=\"commentid\" value=\"%d\">", $_POST['commentID']);
    printf($_POST['commentID']);

    ?>
    <input type="submit" name="submit">
  </form>
</div>
</body>

</html>
