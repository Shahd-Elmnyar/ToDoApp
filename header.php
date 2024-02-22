<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do App</title>
    <link rel = "stylesheet" href = "css/reset.css">
    <link rel = "stylesheet" href = "css/style.css">
</head>


<body>
    <nav>
        <div class = "wrapper">
            <!--<a href = "index.php"><img src = "img/logo.jpg" alt =" Blogs logo" ></a>-->
            <ul>
                <?php
                if  (isset($_SESSION["usersUid"])){
                    echo " <li><a href = '../login.php'  class='logout-link'>Log out</a></li>";
                }
                else {
                    echo " <li><a href= 'index.php' >Home</a></li>";
                    echo " <li><a href = 'signup.php'>Sign Up</a></li>";
                    echo " <li><a href = 'login.php'>Log In</a></li>";
                }
                ?>
            </ul>
        </div>
    </nav>
    <div class = "wrapper">