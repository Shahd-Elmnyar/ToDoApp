<?php
session_start();
require_once '../../includes/dbh.inc.php';

if (isset($_GET['id'])){
    $id = $_GET["id"];

    // Call the stored procedure to retrieve task details
    $sql = "{CALL GetTaskById(?)}";
    $params = array($id);
    $stmt = sqlsrv_prepare($conn, $sql, $params);
    $result = sqlsrv_execute($stmt);

    if (!$result) {
        $_SESSION['errors'] = "Error retrieving task details: " . print_r(sqlsrv_errors(), true);
        header("Location:../home.php");
        exit();
    }

    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

    if (!$row) {
        $_SESSION['errors'] = "Data for the given ID does not exist";
        header("Location:../home.php");
        exit();
    }

    // Call the stored procedure to delete the task
    $sqlDelete = "{CALL DeleteTaskById(?)}";
    $paramsDelete = array($id);
    $stmtDelete = sqlsrv_prepare($conn, $sqlDelete, $paramsDelete);
    $resultDelete = sqlsrv_execute($stmtDelete);

    if (!$resultDelete) {
        $_SESSION['errors'] = "Error deleting task: " . print_r(sqlsrv_errors(), true);
        header("Location:../home.php");
        exit();
    }

    $_SESSION['success'] = "The task is deleted successfully";
    header("Location:../home.php");
    exit();
}
?>
