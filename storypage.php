<!doctype html>
<html>

<head>
  <link rel="stylesheet" type="text/css" href="main.css">
  <title>330 News</title>
</head>

<ul>
  <li><a href="home.php">Back</a></li>
</ul>

<body>
<br><br><br><br>
<?php

require 'database.php';
session_start();

$storyID = 1;

$stmt = $mysqli->prepare("select title, author, authorid, date, body, link from stories where storyid=?");
if (!$stmt) {
  printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('s', $storyID);
$stmt->execute();
$stmt->bind_result($title, $author, $authorid, $date, $body, $link);
$stmt->fetch();
$stmt->close();

echo("<div id=\"articledisplay\" class=\"article\">");
printf("<div id=\"headline\" class=\"article\">%s</div>", $title);
printf("<div id=\"date\" class=\"article\">Posted on: %s</div>", $date);
printf("<div id=\"author\" class=\"article\">By: %s<br><br></div>", $author);
printf("<div id=\"articlebody\" class=\"article\">%s<br><br></div>", $body);
echo("</div>");

echo("<div id=\"actions\">");
echo($_SESSION['uid']);
if (isset($_SESSION['uid'])) {
  if ($_SESSION['uid'] == $authorid) {
    echo("<a href=\"editstory.php\">Edit</a>");
    echo("<a href=\"removestory.php\">Delete</a>");
  }
  echo("Submit a comment");
  echo("<form action=\"post-comment.php\" method=\"post\">");
  echo("<p><input type=\"text\" id=\"commenttext\" name=\"commenttext\"></p>");
  printf("<input type=\"hidden\" name=\"storyid\" value=\"%s\">", $storyID);
  echo("<p><input type=\"submit\" name=\"postcomment\" id=\"postcomment\"></p>");
  echo("</form>");
}
echo("</div>");

echo("<div id=\"comments\">");
echo("Comments<br><br>");
//echo("<ul>");
$stmt = $mysqli->prepare("select text, commenter, commenterid, stamp, upvotes, downvotes, commentid from comments where loc=?");
if (!$stmt) {
  printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('i', $storyID);
$stmt->execute();
$stmt->bind_result($text, $commenter, $commenterID, $commentTime, $upvotes, $downvotes, $commentID);
while ($stmt->fetch()) {
  printf("At %s, %s wrote:<br>\"%s\"<br>", $commentTime, $commenter, $text);
  if (isset($_SESSION['uid'])) {
    if ($_SESSION['uid'] == $commenterID) {
      echo("<form action=\"delete-comment.php\" method=\"post\">");
      echo("<input type=\"submit\" name=\"button\" value=\"Delete\">");
      printf("<input type=\"hidden\" name=\"commentID\" value=\"%s\"></form>", $commentID);
      echo("<form action=\"edit-comment.php\" method=\"post\">");
      echo("<input type=\"submit\" name=\"button\" value=\"Edit\">");
      printf("<input type=\"hidden\" name=\"commentcontent\" value=\"%s\">", $text);
      printf("<input type=\"hidden\" name=\"commentID\" value=\"%s\"></form>", $commentID);
    }
  }
}
$stmt->close();
//echo("</ul>");
echo("</div>");

?>
</body>
</html>
