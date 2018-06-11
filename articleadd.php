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
            <h1 id="title"> Personal Finance Canada Blog</h1>
        </div>
        <?php
        require_once "db.php";

        if (!isset($_SESSION['auth'])) {

            echo '<h2 id="logInId">Please <a href="login.php" class="links">LOG IN</a> or <a href="register.php" class="links">REGISTER</a> to view this page.</h2>';
            /* header('location:login.php'); */
        } else {
            echo '<div id="logout">';
            echo 'You are logged in as <span class="loggedInAs">' . $_SESSION['auth']['name'] . '</span>';
            echo '<span><a href="logout.php" style="font-family:Arial;"> Logout</a> </span>';
            echo '</div>';
            echo '<h2 class="loginTitle1">Create a New Article</h2>';

            function getForm($title, $content) {
                $form = <<< ENDIT
            <div id="mainArticleAdd">
            <form method="POST" id="formarticleadd" name="article[]">  
                <p style="margin-left:25px;"><label for="articleTitle" style="padding-right:15px" class="logintitle"> Title: </label><input  style="width:500px;margin-left:0px;padding-right:2px" type="text" name="title" id="articleTitle" value="$title"></p>      
                <p><label for="articleBox" class="logintitle">Content:</label><textarea style="width:500px;" name="content" rows="15" cols="65" id="articleBox">$content</textarea></p>      
                <input type="submit" value="Create"><br/><br/>      
            </form>
            </div>     
ENDIT;
                return $form;
            }

            if (!isset($_POST['title'])) {
                echo getForm("", "");
            } else {
                $title = $_POST['title'];
                $content = $_POST['content'];
                $errorList = array();

                if (strlen($title) < 10) {
                    array_push($errorList, "Title must be over 10 characters long.");
                }

                if (strlen($content) < 50) {
                    array_push($errorList, "Article must be at least 50 characters long.");
                }

                echo getForm($title, $content);

                if ($errorList) {
                    echo "<h3 class='loginTitle1'>Submission failed</h3>\n";
                    echo "<ul>\n";
                    foreach ($errorList as $error) {
                        echo "<li class='errorList'>"
                        . $error . "</li>\n";
                    }
                    echo '</ul>';
                } else {
                    $query = mysqli_prepare($link, "INSERT INTO article VALUES ( NULL, ?, CURRENT_TIMESTAMP, ?, ?)");
                    $sql = mysqli_stmt_bind_param($query, 'sss', $_SESSION['auth']['userID'], $title, $content);
                    $result = mysqli_stmt_execute($query);
                    echo '<p id="submissionSuccessful">SUCCESS! Click to visit the <a href="index.php">INDEX</a>.</p>';


                    if (!$result) {
                        echo "Error while executing query: $sql<br>" . PHP_EOL;
                        echo "Debugging error: " . mysqli_connect_error() . "<br>" . PHP_EOL;
                        echo "Debugging error: " . mysqli_connect_error() . "<br>" . PHP_EOL;
                        exit;
                    }
                }
            }
        }
  