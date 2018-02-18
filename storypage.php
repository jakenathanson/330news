<!doctype html>
<html>

<head>
  <link rel="stylesheet" type="text/css" href="main.css">
  <title>330 News</title>
</head>

<ul>
  <li><a href="stories.php">Back</a></li>
</ul>

<body>

<?php

require 'database.php';

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
printf("<div id=\"date\" class=\"article\">%s</div>", $date);
printf("<div id=\"author\" class=\"article\">%s</div>", $author);
printf("<div id=\"articlebody\" class=\"article\">%s</div>", $body);
echo("</div>")

if (isset($_SESSION['uid'])) {
  if ($_SESSION['uid'] == $authorid) {
    echo("<a href=\"editstory.php\">Edit</a>")
  }
}

?>
</body>
</html>
