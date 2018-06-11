<!DOCTYPE html>
<html>
    <head>
	<meta charset="utf-8"/>
	<title>LOGIN</title>
        <link rel="stylesheet" href="main.css"/>
    </head>
    <body>
        <div id="headerWrapper"> 
            <img src="images/leaf.png" alt="leaf" width="85" height="85"  id="logo"/>    
            <h1 id="title">Personal Finance Canada Blog</h1>
        </div>       
<?php                   
 
require_once "db.php";
echo '<h1 class="loginTitle1">User login</h1>'; 

function getForm($user, $pass) {  
$form = <<< ENDIT
   <div>
   <form method="POST" id="formregister"  name="authenticate[]"> 
        <br/><br/>
        <p class="loginTitle1"><label for="username" id="labelsLogin">Username:</label><input type="text" name="user" id="username" value="$user"></p>
        <p class="loginTitle1"><label for="login" id="labelsLogin1">Password:</label><input type="password" name="password" id="login" value="$pass"></p><br/>	
        <p class="loginTitle1"><input type="submit" value="Login"></p><br/>
    </form>
    </div>    
ENDIT;
    return $form;}
 
if (!isset($_POST['user']))  {  
echo getForm("", "");

} else {
    $user = $_POST['user'];
    $pass = $_POST['password'];
    $errorList = array();   
  
$query = mysqli_prepare($link, "SELECT name, userID, password  FROM user WHERE name=?"); 
mysqli_stmt_bind_param($query, "s", $user); 
mysqli_stmt_execute($query);
mysqli_stmt_bind_result($query, $name, $nameID, $password);
mysqli_stmt_fetch($query);

  if($password != $pass || $user != $name || $user==""){
    array_push($errorList, "Invalid username or password");
    $user = "";
    $pass ="";
    echo getForm("","");
}


if ($errorList) {
    echo "<h3 style='text-align:center; color:#EB3514;'>Invalid Username or Password!</h3>";
} else{
$_SESSION['auth'] = array(
'userID' => $nameID,
'name' => $name, 
);

echo '<h2 style="text-align:center";> Welcome ' . $_SESSION['auth']['name'] . ', Click to <a href="articleadd.php">' . 'add an article</a>' . ' or <a href="index.php">' . 'visit the index</a></h2>';
 }
}
 echo '<p id="needAccount"><b>Need an account? <a href="register.php" style="font-family:Arial;">Register here.</a></b></p>';  
         

