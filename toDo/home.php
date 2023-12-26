<?php
    include_once '../header.php';
    require_once '../includes/dbh.inc.php';

    // procedure

    $sql="SELECT * FROM [task] ORDER BY id DESC ";
    $result = sqlsrv_query($conn , $sql);

    // $sql2="SELECT * FROM [users] ORDER BY usersId DESC ";
    // $result2 = sqlsrv_query($conn , $sql2);

    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <title>Document</title>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-8 mx-auto">
                <form action="handlers/store-task.php" method="POST" class="form border p-2 my-5">
                <?php if(isset($_GET['ms'])):?>
                    <div class ="alert alert-danger text-center">
                    <?php
                    echo $_GET['ms'];
                    ?>
                    </div>
                    <?php endif; ?>
                <?php if (isset($_SESSION['success'])):  ?>
                    <div class ="alert alert-success text-center">
                        <?php 
                            echo $_SESSION['success']; 
                            unset($_SESSION['success']); // when reload the session message will disappear
                        ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($_SESSION['errors'])):  ?>
                    <div class ="alert alert-danger text-center">
                        <?php 
                            echo $_SESSION['errors']; 
                            unset($_SESSION['errors']); 
                        ?>
                    </div>
                <?php endif; ?>
                <?php //$row2 = sqlsrv_fetch_array($result2, SQLSRV_FETCH_ASSOC)?>
                    <input type="text" name="title" class="form-control my-3 border border-success" placeholder="add new task">
                    <input type="submit" name="usersId" value="Add" class="form-control btn btn-primary my-3 " placeholder="add new task" <?php //echo $row2['usersId'];?>>
                </form>
            </div>
            <div class="col-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <!-- <th>#</th> -->
                            <th>Task</th>
                            <th>done </th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php


if (isset($_SESSION['usersId'])) {
    $userId = $_SESSION['usersId'];

    // Call the UDF to get the task count for the user
    $sql = "SELECT dbo.GetTaskCountForUser(?) AS TaskCount";
    $params = array($userId);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        $_SESSION['errors'] = "Error retrieving task count: " . print_r(sqlsrv_errors(), true);
        header("Location:../home.php");
        exit();
    }

    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

    if ($row) {
        $taskCount = $row['TaskCount'];
        echo "Task count : $taskCount";
        // Use $taskCount in your application as needed
    } else {
        $_SESSION['errors'] = "Task count not available";
        header("Location:../home.php");
        exit();
    }
} else {
    $_SESSION['errors'] = "User ID not found in session";
    header("Location:../home.php");
    exit();
}
?>
<?php
if (isset($_SESSION['usersId'])) {
    $userId = $_SESSION['usersId'];

    // Call the stored procedure to get the count of completed tasks
    $sql = "{CALL GetDoneTaskCount(?)}";
    $params = array($userId);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        $_SESSION['errors'] = "Error retrieving task count: " . print_r(sqlsrv_errors(), true);
        header("Location:../home.php");
        exit();
    }

    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

    if ($row) {
        $doneTaskCount = $row['DoneTaskCount'];
        echo "<br> Number of completed tasks : $doneTaskCount ";
        // Use $doneTaskCount in your application as needed
    } else {
        $_SESSION['errors'] = "Task count not available";
        header("Location:../home.php");
        exit();
    }
} else {
    $_SESSION['errors'] = "User ID not found in session";
    header("Location:../home.php");
    exit();
}
?>

                <?php
                if (isset($_SESSION['usersId'])) {
                    $usersId = $_SESSION['usersId'];
                    // Fetch tasks for the logged-in user
                    $sql = "SELECT * FROM [task] WHERE [usersId] = ?";
                    $params = array($usersId);
                    $result = sqlsrv_query($conn, $sql, $params);
                    // Display the tasks
                    if ($result) {
                        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) :?>

                        <tr></tr>
                                <!-- <td><?php 
                                //echo $row['id']; ?></td> -->
                                <td><?php echo $row['title']; ?></td>
                                <td>
                                    <form action="handlers/done.php?id=<?php echo $row['id']; ?>" method="POST">
                                        <input type="hidden" name="previous_state" value="<?php echo $row['status']; ?>">
                                        <input type="checkbox" name="states" <?php if ($row['status'] == 1) echo 'checked'; ?>>
                                        <input type="submit" value="Save" class="form-control btn btn-primary my-3" placeholder="Save" >
                                    </form>
                                </td>
                                <td>
                                    <a href="handlers/delete-task.php?id=<?php echo $row['id'];?>" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i> </a>
                                    <a href="update.php?id=<?php echo $row['id'];?>" class="btn btn-info"><i class="fa-solid fa-edit"></i> </a>
                                    
                                </td>
                            </tr>
                        <?php endwhile;
                    } else {
                        echo "Error fetching tasks: " . print_r(sqlsrv_errors(), true);
                    }
                    } else {
                        echo "User ID not found in session.";
                    }
                ?>
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="script.js"></script>
</body>

</html>
