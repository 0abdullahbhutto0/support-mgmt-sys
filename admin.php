<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LiveSupport Admin</title>
     <style>
        table, td, th{
            border: 1px solid;
            border-collapse:collapse;

        }
    </style>
</head>

<body>

</body>

</html>

<?php
session_start();
include("database.php");
if ($_SESSION['logged_in'] == 'true') {
    if ($_SESSION['role'] == 'admin') {
        echo "<h2>Hello Admin: {$_SESSION['name']}</h2><br>";
        echo "<form action='admin.php' method='post'>
            <input type='submit' name='logout' value='Logout'>
        </form>";
        echo "<br><h3>Tickets</h3>";
        if(isset($_POST['logout'])){
            session_destroy();
            header("Location: index.php");
            exit();
        }
        $sql = "SELECT t.*, u.name, u.username FROM tickets t INNER JOIN users u ON t.user_id = u.id";
        $result=mysqli_query($conn, $sql);
        echo "<table>
            <tr>
                <th>
                    Ticket ID
                </th>
                <th>
                    Created By
                </th>
                <th>
                    Subject
                </th>
                <th>
                    Status
                </th>
                <th>
                    Created At
                </th>
                <th>
                    Updated At
                </th>
                <th>
                    Thread
                </th>
            </tr>
        
        ";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['username']}</td>";
            echo "<td>{$row['subject']}</td>";
            echo "<td>{$row['status']}</td>";
            echo "<td>{$row['created_at']}</td>";
            echo "<td>{$row['updated_at']}</td>";
            echo "<td> <a href='thread.php?id={$row['id']}'>Open Thread</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    }else{
        echo "User doesnt have admin privileges";
        echo "<br><a href='user.php'>Go back to User Page</a>";
    }
} else {
    header("Location: index.php");
    exit();
}



?>