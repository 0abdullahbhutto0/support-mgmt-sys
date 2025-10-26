<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LiveSupport</title>
    <link rel='stylesheet' href='layout.css'>
    <script
      src="https://kit.fontawesome.com/37d0d17982.js"
      crossorigin="anonymous"
    ></script>
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
    echo "<h3 class='resolved-head'>Created by: {$row['name']}</h3>";
    echo "<h3 class='resolved-head' style='font-size:40px'>Ticket Subject: {$row['subject']}</h3>";
    echo "<h4 class='resolved-head' style='font-size:25px'>Description: {$row['description']}</h4>";
    echo "<h4 class='resolved-head'>Thread</h4>";
    $sql_comm = "SELECT c.*, u.role, u.name FROM comments c INNER JOIN users u ON c.user_id = u.id WHERE ticket_id = '{$_SESSION['ticket_id']}'";
    $result = mysqli_query($conn, $sql_comm);
    echo "<div class='thread-comments'>";

    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['role'] == 'user') {
            echo "<div class='message-user'>";
            echo "<div class='name'>{$row['name']}</div>";
            echo "<div class='text'>{$row['message']}</div>";
            echo "<div class='timestamp'>{$row['created_at']}</div>";
            echo "</div>";
        } else {
            echo "<div class='message-admin'>";
            echo "<div class='name'>{$row['name']}</div>";
            echo "<div class='text'>{$row['message']}</div>";
            echo "<div class='timestamp'>{$row['created_at']}</div>";
            echo "</div>";
        }
    }

    echo "</div>";
    echo
    "
    <div class='searchbar-container'>
        <form action='thread.php' method='post'>
            <input type='text' name='comment' placeholder='Post an update or comment'>
            <input type='submit' name='submit_comment' value='Post'>
        </form>
        </div>
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
        echo "<nav>";
        echo "<h2><i class='fa-solid fa-headset'></i>LiveSupport</h2>";
        echo "<h2>Hello, Admin: {$_SESSION['name']}</h2>";
        echo "<form action='thread.php' method='post'>
            <input type='submit' name='back' value='Back'>
        </form>";
        echo "</nav>";
        echo "<br><h2 class='resolved-head' style='font-size:32px;'>Ticket `{$_SESSION['ticket_id']}` Thread</h2>";
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
        echo "<h3 class='resolved-head'>Current Status: {$row['status']}</h3><br>
        <div class='status-submit'>
        <form action='thread.php' method='post'>
        <select name='status'>
            <option value='In Progress'>In Progress</option>
            <option value='Resolved'>Resolved</option>
        </select>
        <input type='submit' name='status_sub'>
        </form>
        </div>
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
        echo "<nav>";
        echo "<h2><i class='fa-solid fa-headset'></i>LiveSupport</h2>";
        echo "<h2>Hello, {$_SESSION['name']}</h2>";
        echo "<form action='thread.php' method='post'>
            <input type='submit' name='back' value='Back'>
        </form>";
        echo "</nav>";
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