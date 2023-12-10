<?php 
if (isset($_POST["submit"])){
    $name = $_POST["name"];
    $email = $_POST["email"];
    $username = $_POST["uid"];
    $pass = $_POST["password"];
    $passrepeat= $_POST["passrepeat"];
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';
    
    if (emptyInputSignup($name,$email,$username,$pass,$passrepeat)!==false){
        header("Location: ../signup.php?error=emptyinput");
        exit();
    }
    if (invalidUid($username)!==false){
        header("Location: ../signup.php?error=invaliduid");
        exit();
    }
    if (invalidEmail($email)!==false){
        header("Location: ../signup.php?error=invalidemail");
        exit();
    }
    if (passMach($pass , $passrepeat)!==false){
        header("Location: ../signup.php?error=passwordsdontmatch");
        exit();
    }
    if (uidExists($conn , $username ,$email)!==false){
        header("Location: ../signup.php?error=usernametaken");
        exit();
    }

    createUser($conn,$name,$email,$username,$pass);
}
else{
    header("Location: ../signup.php");
}