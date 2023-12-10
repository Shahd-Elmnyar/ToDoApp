<?php
    session_start();
    require_once '../../includes/dbh.inc.php';
    if (isset($_GET['id']) && isset($_POST['states'])) {
        $id = $_GET["id"];
        $currentState = isset($_POST['states']) ? 1 : 0;
        $previousState = $_POST['previous_state'];

        if ($currentState != $previousState) {
            // procedure
            $sql = "UPDATE [task] SET [status] = $currentState WHERE [id] = $id";
            $result = sqlsrv_query($conn, $sql);

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