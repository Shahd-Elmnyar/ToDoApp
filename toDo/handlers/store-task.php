<?php
session_start();
require_once '../../includes/dbh.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['title'])) {
    $title = trim(htmlspecialchars(htmlentities($_POST['title'])));

    if (empty($title)) {
        header("Location: ../home.php?ms=Task is required");
        exit;
    }
    if (strlen($title) < 3) {
        $_SESSION['errors'] = "Title of the task must be greater than 3 characters";
    } else {
        if (isset($_SESSION['usersId'])) {
            $usersId = $_SESSION['usersId'];
            $sql = "EXEC InsertTask ?, ?";
            $params = array($title, $usersId);
            $result = sqlsrv_query($conn, $sql, $params);

            if ($result) {
                $rowsAffected = sqlsrv_rows_affected($result);

                if ($rowsAffected === false) {
                    echo "Error retrieving rows affected";
                } elseif ($rowsAffected > 0) {
                    $_SESSION['success'] = "The new task is added successfully";
                }
            } else {
                echo "Error: " . print_r(sqlsrv_errors(), true);
            }
        } else {
            $_SESSION['errors'] = "User not logged in";
        }
    }
}
header("Location:../home.php");


//Test branch for testing 