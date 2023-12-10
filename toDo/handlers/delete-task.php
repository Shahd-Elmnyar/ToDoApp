<?php
    session_start();
    require_once '../../includes/dbh.inc.php';

    if (isset($_GET['id'])){
        $id = $_GET["id"];
        //procedure
        $sql = "SELECT* FROM [task] where [id] = '$id'";
        $result = sqlsrv_query($conn, $sql);
        $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
        if(!$row){
            $_SESSION['errors']= "data not exists";
        }else{
            //procedure 
            $sql = "DELETE FROM [task] where [id] = '$id'";
            $result = sqlsrv_query($conn, $sql);
            $_SESSION['success']= "the task is deleted successfully";
        }
        //redirection 
        header("Location:../home.php");
    }
