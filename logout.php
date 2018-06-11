<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Logout</title>
        <link rel="stylesheet" href="main.css"/>	
    </head>
    <?php
    require_once 'db.php';
    unset($_SESSION['auth']);
    ?>
    <body>

        <div id="headerWrapper"> 
            <img src="images/leaf.png" alt="leaf" width="85" height="85"  id="logo"/>    
            <h1 id="title">Personal Finance Canada Blog</h1>
        </div>

        <div style="text-align:center;">
            <h1> You have successfully logged out. </h1><br/>

            <p style="font-size:150%"> <b> Click to <a href="login.php" style="font-family:Arial">Log In</a> or <a href="register.php" style="font-family:Arial;">Register.</a></b></p><br/><br/>
            <img src="images/thumbsup.png" alt="Thumps up!" width="110" height="110" />

        </div>
    </body>
</html>
