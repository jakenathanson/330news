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

error_reporting(0);

require 'database.php';
session_start();

// if user accesses a new story, update the session storyid
if (isset($_POST['storyid'])) {
  $_SESSION['currStory'] = $_POST['storyid'];
}
// otherwise, just update variable to reflect current story
$storyID = $_SESSION['currStory'];

echo($storyID);

// get story information from database
$stmt = $mysqli->prepare("select title, author, authorid, date, body, link from stories where storyid=?");
if (!$stmt) {
  printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('s', $storyID);
$stmt->execute();
// set variables
$stmt->bind_result($title, $author, $authorid, $date, $body, $link);
$stmt->fetch();
$stmt->close();

// display header information
echo("<div id=\"articledisplay\" class=\"article\">");
printf("<div id=\"headline\" class=\"article\">%s</div>", $title);
printf("<div id=\"date\" class=\"article\"><br>Posted on: %s</div>", $date);
printf("<div id=\"author\" class=\"article\">By: %s<br><br></div>", $author);
printf("<div id=\"articlebody\" class=\"article\">%s<br><br></div>", $body);

echo("<div id=\"actions\">");
// if visitor is logged in...
if (isset($_SESSION['uid'])) {
  // and if their user id matches that of the author...
  if ($_SESSION['uid'] == $authorid) {
    // display form to edit or remove the story
    echo("<form action=\"edit-story.php\" method=\"post\" class=\"commentAction\">");
    echo("<input type=\"submit\" value=\"Edit\">");
    printf("<input type=\"hidden\" name=\"title\" value=\"%s\">", $title);
    printf("<input type=\"hidden\" name=\"body\" value=\"%s\">", $body);
    printf("<input type=\"hidden\" name=\"storyid\" value=\"%s\">", $storyID);
    printf("<input type=\"hidden\" name=\"link\" value=\"%s\"></form>", $link);
    echo("<form action=\"delete-story.php\" method=\"post\" onsubmit=\"return confirm('Are you sure you want to delete your story?')\" class=\"commentAction\">");
    echo("<input type=\"submit\" value=\"Remove\">");
    printf("<input type=\"hidden\" name=\"thestoryid\" value=\"%s\"></form><br><br>", $storyID);
  }
  // if user is logged in but not the author, display comment form
  echo("Submit a comment");
  echo("<form action=\"post-comment.php\" method=\"post\">");
  echo("<p><input type=\"text\" id=\"commenttext\" name=\"commenttext\"></p>");
  printf("<input type=\"hidden\" name=\"storyid\" value=\"%s\">", $storyID);
  echo("<p><input type=\"submit\" name=\"postcomment\" id=\"postcomment\"></p>");
  echo("</form>");
}
echo("</div>");

// in any case, display story comments
echo("<div id=\"comments\">");
echo("Comments<br><br>");

// get comment info from database
$stmt = $mysqli->prepare("select text, commenter, commenterid, stamp, upvotes, downvotes, commentid from comments where loc=?");
if (!$stmt) {
  printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('i', $storyID);
$stmt->execute();
// set variables
$stmt->bind_result($text, $commenter, $commenterID, $commentTime, $upvotes, $downvotes, $commentID);
// iteratively generate html for comment display
while ($stmt->fetch()) {
  printf("At %s, %s wrote:<br>%s<br>", $commentTime, $commenter, $text);
  // if visitor is logged in...
  if (isset($_SESSION['uid'])) {
    // and they are identified as the comment poster...
    if ($_SESSION['uid'] == $commenterID) {
      // display form to edit/delete comment
      echo("<div id=\"commentButtons\">");
      echo("<form action=\"delete-comment.php\" method=\"post\" class=\"commentAction\" onsubmit=\"return confirm('Are you sure you\'d like to delete your comment?')\">");
      echo("<input type=\"submit\" name=\"button\" value=\"Delete\">");
      printf("<input type=\"hidden\" name=\"commentID\" value=\"%s\"></form>", $commentID);
      echo("<form action=\"edit-comment.php\" method=\"post\" class=\"commentAction\">");
      echo("<input type=\"submit\" name=\"button\" value=\"Edit\">");
      printf("<input type=\"hidden\" name=\"commentcontent\" value=\"%s\">", $text);
      printf("<input type=\"hidden\" name=\"commentID\" value=\"%s\"></form><br><br>", $commentID);
      echo("</div>");
    } else {
      echo("<br>");
    }
  } else {
    echo("<br>");
  }
}
$stmt->close();
echo("</div>");
echo("</div>")

?>
</body>
</html>
