<?php
session_start();
require_once '../../includes/dbh.inc.php';


if (isset($_GET['id'])) {
    $id = $_GET["id"];
    $currentState = isset($_POST['states']) ;
    $previousState = $_POST['previous_state'];

    if ($currentState != $previousState) {
        // Prepare and execute the stored procedure
        $sql = "{CALL UpdateTaskStatus (?, ?)}"; // UpdateTaskStatus is the name of the stored procedure
        $params = array($id, $currentState);
        $result = sqlsrv_query($conn, $sql, $params);

        if ($result) {
            $_SESSION['success'] = "The task status has been updated.";
        } else {
            $_SESSION['errors'] = "Error updating task status.";
        }
    } else {
        $_SESSION['success'] = "No changes made.";
    }
}

$previousPage = $_SERVER['HTTP_REFERER'];
header("Location: $previousPage");
exit();
?>
