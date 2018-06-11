<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>REGISTRATION</title>
        <link rel="stylesheet" href="main.css"/>
    </head>

    <body>  
        <div id="headerWrapper"> 
            <img src="images/leaf.png" alt="leaf" width="85" height="85"  id="logo"/>    
            <h1 id="title">Personal Finance Canada Blog</h1>
        </div>       
        <h2 class="loginTitle1">Please register your login information:</h2>
        <?php
        require_once "db.php";

        function getForm($user, $email) {
            $form = <<< ENDIT
    <div>     
    <form method="POST" id="formregister" name="registration[]">    <!-- Beginning of form -->
        <p><label for="username" class="loginlabels">Username:</label><br/><input type="text" name="username" id="username" value="$user"></p>              
        <p><label for="email" class="loginlabels">Email address:</label><br/><input type="text" name="email" id="email" value="$email"></p>
        <p><label for="pass1" class="loginlabels">Password:</label><br/><input type="password" name="pass1" id="pass1"></p>
        <p><label for="pass2" class="loginlabels">Re-enter Password:</label><br/><span><input type="password" name="pass2" id="pass2"></span></p>
        <p><input type="submit" value="Register"></p>                       
    </form> 
    </div>     
ENDIT;
            return $form;
        }

        if (!isset($_POST['username'])) {
            echo getForm("", "");
        } else {
            $name = $_POST['username'];
            $email = $_POST['email'];
            $pass1 = $_POST['pass1'];
            $pass2 = $_POST['pass2'];
            $errorList = array();

            $nameCheck = checkName($link, $name);

            if ($nameCheck) {
                array_push($errorList, "Username already exists");
                $name = "";
            }

            if (strlen($name) < 4 || strlen($name) > 20) {
                array_push($errorList, "Name must be between 4 and 20 characters long");
                $name = "";
            }
            if (preg_match('/[A-Z]/', $name) === 1) {
                array_push($errorList, "Name must not contain an upper case letter");
                $name = "";
            }
            if (filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE) {
                array_push($errorList, "Invalid email address");
                $email = "";
            }

            echo getForm($name, $email);

            if (preg_match('^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,64}$^', $pass1) === 0) {
                array_push($errorList, "Password must contain 1 lower case, 1 upper case and 1 number");
            }

            if (strlen($pass1) < 6 || strlen($pass2) > 64) {
                array_push($errorList, "Password must be between 6 and 64 characters long");
                $name = "";
            }

            if ($pass1 != $pass2) {
                array_push($errorList, "Passwords do not match");
            }

            if (preg_match('/[A-Z]/', $name) === 1) {
                array_push($errorList, "Name must not contain an upper case letter");
                echo getForm("", "");
                $name = "";
            }

            if ($errorList) {
                echo '<ul>';
                foreach ($errorList as $error) {
                    echo "<li class='errorList'>"
                    . $error . "</li>\n";
                }
                echo '</ul>';
            } else {
                $query = mysqli_prepare($link, "INSERT INTO user VALUES ( NULL,?, ?, ?)");
                $sql = mysqli_stmt_bind_param($query, 'sss', $name, $email, $pass1);
                $result = mysqli_stmt_execute($query);

                if (!$result) {
                    echo "Error while executing query: $sql<br>" . PHP_EOL;
                    echo "Debugging error: " . mysqli_connect_errno() . "<br>" . PHP_EOL;
                    echo "Debugging error: " . mysqli_connect_error() . "<br>" . PHP_EOL;
                    exit;
                }

                echo "</ul>\n\n";
                echo '<h2 style="text-align:center";>Thank you for registering. Click  <a href="login.php"> HERE</a> to log in.</h2>';
            }
        }
        echo '<p id="noAccount"><b>Already have an account? Click to  <a href="login.php" style="font-family:Arial;">LOG IN</a></b></p>';
        