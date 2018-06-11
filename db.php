<?php 

session_start();

$db_user = "blog";
$db_pass ="8AfdJmtvYyRT9CKP";
$db_name = "blog";

$link = mysqli_connect('localhost',$db_user,$db_pass, $db_name, 3306);

if (!$link) {
    echo "Error: Unable to connect to MySQL.<br>" . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . "<br>" . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . "<br>" . PHP_EOL;
    exit;
}

function loadarticle($link, $articleID)
{
$query = mysqli_prepare($link, "SELECT title, name, creationTime, body FROM article, user WHERE article.authorID=user.userID AND articleID=?"); 
mysqli_stmt_bind_param($query, 's', $articleID);
mysqli_stmt_execute($query);
mysqli_stmt_bind_result($query, $title, $name, $creationTime, $body);
mysqli_stmt_fetch($query);
    echo "<div id='individualArticle'>";
    echo "<span style='font:bold 22px Castellar;'>$title</span>";
    echo "<br/><br/><br/>";
    echo "Posted by " . $name;
    echo "<br/>";
    echo $creationTime;
    echo "<br/><br/>";
    echo $body;
    echo "</div>";
    echo "<br/>";
}
                
function loadcomment($link, $articleID)
{
    $query = mysqli_prepare($link, "SELECT user.name, comment.creationTime, comment.body FROM user, comment WHERE comment.authorID=user.userID AND articleID=? ORDER BY comment.creationTime DESC"); 
    mysqli_stmt_bind_param($query, 's', $articleID);
    mysqli_stmt_execute($query);
    mysqli_stmt_bind_result($query, $name, $creationTime, $body);
    $comment="";
    $creationTime="";
    $body="";
    while ($row = mysqli_stmt_fetch($query)) {
        echo "<br/>";
        echo "<div class='commentID'>";
        echo "Posted by " . $name;
        echo "<br/>";
        echo $creationTime;
        echo "<br/>";
        echo $body;
        echo "<br/><br/>";  
        echo "</div>";
        }
}

function addComment($link, $articleID, $comment)
{
    $query = mysqli_prepare($link, "INSERT INTO comment VALUES (NULL, ?, ?, NULL, ?)");
    $sql = mysqli_stmt_bind_param($query, 'dds', $articleID, $_SESSION['auth']['userID'], $comment);
    $result = mysqli_execute($query);
    header("Refresh:0");
    $comment="";
        
    if (!$result) {
        echo "Error while executing query: $sql<br>" . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_errno() . "<br>" . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . "<br>" . PHP_EOL;
        exit;
    }
}

function checkName($link, $name)
{
   $check=FALSE;
   $result='';
   $query = mysqli_prepare($link, "SELECT name FROM user WHERE name=?"); 
   mysqli_stmt_bind_param($query, "s", $name); 
   mysqli_stmt_execute($query);
   mysqli_stmt_bind_result($query, $result);
   mysqli_stmt_fetch($query);
   if($name==$result)
   {
       $check=true;
   } 
   if ($name=="")
   {
       $check=false; 
   }   
   return $check;
}