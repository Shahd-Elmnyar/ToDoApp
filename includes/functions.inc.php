<?php
function emptyInputSignup ($name,$email,$username,$pass,$passrepeat){
    $result;
    if (empty($name)|| empty($email)|| empty($username)|| empty($pass)|| empty($passrepeat)){
        $result= true;
    }
    else {
        $result= false;
    }
    return $result;
}

function invalidUid($username){
    $result;
    if (!preg_match("/^[a-zA-Z0-9]*$/",$username)){
        $result= true;
    }
    else {
        $result= false;
    }
    return $result;
}

function invalidEmail($email){
    $result;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $result= true;
    }
    else {
        $result= false;
    }
    return $result;
}

function passMach($pass , $passrepeat){
    $result;
    if ($pass !== $passrepeat){
        $result= true;
    }
    else {
        $result= false;
    }
    return $result;
}
function uidExists($conn, $username, $email){
    $sql = "SELECT * FROM users WHERE usersUid = ? OR usersEmail = ?";
    $params = array($username, $email);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        header("Location: ../signup.php?error=stmtFailed");
        exit();
    }

    $resultData = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    if ($resultData) {
        return $resultData;
    } else {
        return false;
    }

    sqlsrv_free_stmt($stmt);
}

function createUser($conn, $name, $email, $username, $pass){
    $sql = "INSERT INTO users (usersName, usersEmail, usersUid, usersPass) VALUES (?, ?, ?, ?)";
    $hashedPass = password_hash($pass, PASSWORD_DEFAULT);
    $params = array($name, $email, $username, $hashedPass);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        header("Location: ../signup.php?error=stmtFailed");
        exit();
    }

    header("Location: ../signup.php?error=none");
    exit();
}

function emptyInputLogin ($username,$pass){
    $result;
    if ( empty($username)|| empty($pass)){
        $result= true;
    }
    else {
        $result= false;
    }
    return $result;
}
// function loginUser($conn,$username,$pass){
//     $uidExist = uidExists($conn, $username , $username);
//     if ($uidExist ===false ){
//         header ("Location: ../login.php?error=wrongLogin");
//         exit();
//     }
//     $passHashed = $uidExist["usersPass"];
//     $checkedPass = password_verify($pass,$passHashed);
//     if ($checkedPass === false) {
//         header ("Location: ../login.php?error=wrongLogin");
//         exit();
//     }elseif($checkedPass===true){
//         session_start();
//         $_SESSION['usersId'] = $uidExist["usersId"];
//         $_SESSION['usersUid'] = $uidExist["usersUid"];
//         header ("Location: ../index.php");
//         exit();
//     }
// }

function loginUser($conn, $username, $pass){
    try {
        $uidExist = uidExists($conn, $username, $username);

        if ($uidExist === false) {
            throw new Exception("User not found");
        }

        $passHashed = $uidExist["usersPass"];
        $checkedPass = password_verify($pass, $passHashed);

        if ($checkedPass === false) {
            throw new Exception("Incorrect password");
        } elseif ($checkedPass === true) {
            session_start();
            $_SESSION['usersId'] = $uidExist["usersId"];
            $_SESSION['usersUid'] = $uidExist["usersUid"];
            
            header("Location: ../toDo/home.php?usersId=" .$uidExist["usersId"]);
            exit();
        }
    } catch (Exception $e) {
        echo ("Login error: " . $e->getMessage());
        header("Location: ../login.php?error=wrongLogin");
        exit();
    }
}