<?php
    session_start();
    require_once '../../includes/dbh.inc.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['title'])){
        $title = trim(htmlspecialchars(htmlentities($_POST['title'])));
        $id = $_GET['id'];

        if (strlen($title) < 3){
            $_SESSION['errors'] = "Title of the task must be greater than 3 characters";
        } else {
            //procedure 
            $sql = "{call UpdateTaskTitle(?, ?)}";
            $params = array($title, $id);
            $result = sqlsrv_query($conn, $sql, $params);
            
            if ($result) {
                $rowsAffected = sqlsrv_rows_affected($result);

                if ($rowsAffected === false) {
                    echo "Error retrieving rows affected";
                } elseif ($rowsAffected > 0) {
                    $_SESSION['success'] = "The task is edited successfully";
                } else {
                    header("Location:../update.php?id=" . $id);
                }
            } else {
                echo "Error: " . print_r(sqlsrv_errors(), true);
            }
        }
        header("Location:../home.php");
    }
?>
