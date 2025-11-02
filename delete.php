<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LiveSupport Admin</title>
    <link rel='stylesheet' href='layout.css'>
</head>

<body>

</body>

</html>

<?php
include("database.php");
if ($_SESSION['role'] == 'admin') {
    if (isset($_GET['id'])) {
        $_SESSION['ticket_id'] = $_GET['id'];
    }
    echo "<h2 class='resolved-head'>Are you sure you want to delete ticket {$_SESSION['ticket_id']}?</h2>";
    echo "
        <div class='searchbar-container'>
            <form action='delete.php' method='post'>
                <input type='text' name='confirmtext' placeholder='Type Yes or No...'>
                <input type='submit' name='confirm' value='Confirm'>
            </form>
        </div>";

    if (isset($_POST['confirm'])) {
        if (!empty($_POST['confirmtext'])) {
            if (strtolower($_POST['confirmtext']) == 'yes') {
                $sql = "DELETE FROM comments WHERE ticket_id = {$_SESSION['ticket_id']}";
                mysqli_query($conn, $sql);

                $sql = "DELETE FROM tickets WHERE id = {$_SESSION['ticket_id']}";
                mysqli_query($conn, $sql);
                echo "<h2 class='resolved-head' style='font-size: 25px;'>Ticket deleted!</h2>";
                echo "<h2 class='resolved-head'><a href='admin.php'>Go Back</a></h2>";
                exit();
            } else if (strtolower($_POST['confirmtext']) == 'no') {
                header("Location: admin.php");
                exit();
            } else {
                echo "<h2 class='resolved-head' style='font-size: 15px;'>Please enter Yes or No</h2>";
            }
        } else {
            echo "<h2 class='resolved-head' style='font-size: 15px;'>Please Confirm</h2>";
        }
    }
}else{
    echo "User doesnt have admin privileges";
        echo "<br><a class='resolved-head' href='user.php'>Go back to User Page</a>";
        exit();
}



?>