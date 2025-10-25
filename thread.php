<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LiveSupport</title>
    <style>
        .thread-comments {
            border: 1px solid;
            border-radius: 15%;
            width: 600px;
            height: 400px;
            overflow-y: auto;
            background-color: bisque;
            padding: 45px;
        }
    </style>
</head>

<body>

</body>

</html>

<?php
session_start();
include("database.php");
function thread()
{
    include("database.php");
    $sql_tic_det = "SELECT t.*, u.name FROM tickets t INNER JOIN users u ON t.user_id = u.id  WHERE t.id = '{$_SESSION['ticket_id']}'";
    $result = mysqli_query($conn, $sql_tic_det);
    $row = mysqli_fetch_assoc($result);
    echo "<h3>Created by: {$row['name']}</h3>";
    echo "<h3>Ticket Subject: {$row['subject']}</h3><br>";
    echo "<h4>Description: {$row['description']}</h4>";
    echo "<h4>Thread</h4>";
    $sql_comm = "SELECT c.*, u.role, u.name FROM comments c INNER JOIN users u ON c.user_id = u.id WHERE ticket_id = '{$_SESSION['ticket_id']}'";
    $result = mysqli_query($conn, $sql_comm);
    echo "
        <div class='thread-comments'>";

    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['role'] == 'user') {
            echo "<br>{$row['name']}: {$row['message']}<br>";
            echo $row['created_at'];
        } else {
            echo "<br>{$row['name']}: {$row['message']}<br>";
            echo $row['created_at'];
        }
    }
    echo "</div>
        
        ";
    echo
    "
        <form action='thread.php' method='post'>
        <label>Comment</label>
            <input type='text' name='comment' placeholder='Update'><br>
            <input type='submit' name='submit_comment' value='Post Comment'>
        </form>
        ";
    if (isset($_POST['submit_comment'])) {
        if (!empty($_POST['comment'])) {
            $sql = "INSERT INTO comments(ticket_id, user_id, message) VALUES('{$_SESSION['ticket_id']}', '{$_SESSION['id']}', '{$_POST['comment']}')";
            mysqli_query($conn, $sql);
            header("Location: thread.php");
            exit();
        }
    }
}

if ($_SESSION['logged_in'] == true) {
    if (isset($_GET['id'])) {
        $_SESSION['ticket_id'] = $_GET['id'];
    }
    if ($_SESSION['role'] == 'admin') {
        date_default_timezone_set('Asia/Karachi');
        echo "<h2>Hello Admin: {$_SESSION['name']}</h2><br>";
        echo "<form action='thread.php' method='post'>
            <input type='submit' name='back' value='Back'>
        </form>";
        echo "<br><h2>Ticket `{$_SESSION['ticket_id']}` Thread</h2>";
        $sql_stat = "SELECT status FROM tickets WHERE id='{$_SESSION['ticket_id']}'";
        $result = mysqli_query($conn, $sql_stat);
        $row = mysqli_fetch_assoc($result);
        $current_date_time = date('Y-m-d H:i:s');
        if (strtolower($row['status']) == 'sent') {
            $sql_stat_upd = "UPDATE tickets SET status = 'Received by Admin' WHERE id='{$_SESSION['ticket_id']}'";
            mysqli_query($conn, $sql_stat_upd);
            $current_date_time = date('Y-m-d H:i:s');
            $sql_date_upd = "UPDATE tickets SET updated_at = '{$current_date_time}' WHERE id = {$_SESSION['ticket_id']}";
            mysqli_query($conn, $sql_date_upd);
        }
        echo "<h3>Current Status: {$row['status']}</h3><br>
        <form action='thread.php' method='post'>
        <select name='status'>
            <option value='In Progress'>In Progress</option>
            <option value='Resolved'>Resolved</option>
        </select>
        <input type='submit' name='status_sub'>
        </form>
        ";
        thread();

        if (isset($_POST['back'])) {
            header("Location: admin.php");
            exit();
        }
        if (isset($_POST['status_sub'])) {
            $sql = "UPDATE tickets SET status = '{$_POST['status']}' WHERE id='{$_SESSION['ticket_id']}'";
            mysqli_query($conn, $sql);
            $current_date_time = date('Y-m-d H:i:s');
            $sql_date_upd = "UPDATE tickets SET updated_at = '{$current_date_time}' WHERE id = {$_SESSION['ticket_id']}";
            mysqli_query($conn, $sql_date_upd);
            header("Location: thread.php");
            exit();
        }
    } else {
        echo "<h2>Hello {$_SESSION['name']}</h2><br>";
        echo "<form action='thread.php' method='post'>
            <input type='submit' name='back' value='Back'>
        </form>";
        thread();


        if (isset($_POST['back'])) {
            header("Location: user.php");
            exit();
        }
    }
} else {
    header("Location: index.php");
}

?>