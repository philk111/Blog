<!DOCTYPE html>
<html>
    <head>
	<meta charset="utf-8"/>
	<title>Create an article</title>
	<link rel="stylesheet" href="main.css"/>	
    </head>
        
        <body>
            <div id="headerWrapper"> 
                <img src="images/leaf.png" alt="leaf" width="85" height="85"  id="logo"/>    
                <h1 id="title">Personal Finance Canada Blog</h1>
            </div>
    <?php 
    
require_once "db.php";   
$articleID = $_GET['articleID'];

if (!isset($_SESSION['auth'])){
echo '<h2 id="logout" style="text-align:right; font-size:20px;">Please <a href="login.php">LOG IN</a> or <a href="register.php";">REGISTER</a> to comment.</h2>';
  
} else {
    echo '<div id="logout">';
    echo ' Logged in as <span class="loggedInAs">' . $_SESSION['auth']['name'] . '!</span>';   
    echo '<span><a href="logout.php" style="font-family:Arial;"> Logout</a> </span>';
    echo '<br><br><a class="loggedInAs" href="index.php">' . ' --- BACK TO INDEX ---</a>';
    echo '</div>';  
}
    
function getForm()
{  
$form = <<< ENDIT
    <div id="mainArticleAdd">   
    <form method="POST" id="commentContainer">  
        <span><label for="comment" id="loginlabels">Add comment:</label><textarea style="width:585px; resize:none;" rows="3" cols="100" name="comment" id="comment"></textarea></span>
        <br><span><input type="submit" value="Add Comment"></span>   
    </form> 
    </div>      
ENDIT;
    return $form;
}
        
loadarticle($link, $articleID);
loadcomment($link, $articleID);
            
    if (isset($_SESSION['auth'])){
        if(!isset($_POST['comment']))
        {
            echo getForm();
        }
        else {
            $comment = $_POST['comment'];
            $errorList = array();
            
            if(strlen($comment)<5)
            {
                array_push($errorList, "comment too short");
                $comment="";
                echo getForm();
            }
            
            if ($errorList) {
            echo "<ul>\n";
            foreach ($errorList as $error) {
            echo "<li id='errorList1'>"
            . $error . "</li>\n";
            }
         echo '</ul>';      
    } else {
        addComment($link, $articleID, $comment);
        echo getForm();
        $comment="";
    }
}
}
    