<!DOCTYPE html>
<html>
    <head>
	<meta charset="utf-8"/>
	<title>Index</title>
	<link rel="stylesheet" href="main.css"/>	
    </head>
        <body>
            <div id="headerWrapper"> 
                <img src="images/leaf.png" alt="leaf" width="85" height="85"  id="logo"/>    
                <h1 id="title"> Personal Finance Canada Blog</h1>
            </div>
            

<?php 
require_once 'db.php';

if (!isset($_SESSION['auth'])){
    
    echo '<h2 id="logout" style="text-align:right; font-size:22px;">Please <a href="login.php">LOG IN</a> or <a href="register.php">REGISTER</a> to comment or post an article.</h2>';
   /* header('location:login.php');*/
} else {
    echo '<div id="logout">';
    echo ' Welcome, <span class="loggedInAs">' . $_SESSION['auth']['name'] . '</span>';   
    echo '<span><a href="logout.php" style="font-family:Arial;"> Logout</a> </span><br/>';
    echo '<a class="loggedInAs" href="articleadd.php">' . ' --- add an article ---</a>';
    echo '</div>';  
    echo '<h2 class="loginTitle2">Index page.</h2>';
        }
 
 $query = mysqli_prepare($link, "SELECT title, name, creationTime, body, articleID  FROM article, user WHERE article.authorID=user.userID ORDER BY article.creationTime DESC LIMIT 5"); 
 mysqli_stmt_execute($query);
 mysqli_stmt_bind_result($query, $title, $name, $creationTime, $body, $articleID);
 
 while ($row = mysqli_stmt_fetch($query)) {
    echo "<div class='articles'>";
    echo "<a href='article.php?articleID=" . $articleID . "'>" . $title . "</a>";
    echo "<br><br>";
    echo "Posted by " . ($name);
    echo "<br>";
    echo $creationTime;
    echo "<br>";
    echo substr($body, 0, 200);
    echo "</div>";
    echo "<br><br>";
   
}
 

