<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LiveSupport</title>
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

if ($_SESSION['logged_in'] == true) {
    if ($_SESSION['role'] == 'user') {
        $name = $_SESSION['name'];
        $id = $_SESSION['id'];
        echo "<h2>Hello {$name}</h2>";
        echo "<form action='user.php' method='post'>
            <input type='submit' name='logout' value='Logout'>
        </form>";
        echo "<h3>Facing an issue? Create a Ticket!</h3>";
        echo
        "
        <div class='createticket-container'>
            <form action 'user.php' method='post'>
                <label>Title</label>
                <input type='text' name='subject' placeholder='Enter a subject for the Ticket'><br>
                <label>Description</label><br>
                <textarea name='description' placeholder='Describe your problem'></textarea><br>
                <input type='submit' name='create'>
            </form>
        </div>
        ";
        if(isset($_POST['logout'])){
            session_destroy();
            header("Location: index.php");
            exit();
        }
        if (isset($_POST['create'])) {
            if (!empty($_POST['subject']) || !empty($_POST['description'])) {
                $sql = "INSERT INTO tickets(user_id, subject, description, status) VALUES ('$id', '{$_POST['subject']}', '{$_POST['description']}', 'Sent')";
                mysqli_query($conn, $sql);
                echo "Ticket Posted!";
            } else {
                echo "Please enter all the details";
            }
        }
        echo "<h2>Your Tickets</h2>";
        $sql = "SELECT * FROM tickets WHERE user_id = $id";
        $result = mysqli_query($conn, $sql);
        echo "<table>
            <tr>
                <th>
                    Ticket ID
                </th>
                <th>
                    Subject
                </th>
                <th>
                    Description
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
            </tr>
        
        ";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['subject']}</td>";
            echo "<td>{$row['description']}</td>";
            echo "<td>{$row['status']}</td>";
            echo "<td>{$row['created_at']}</td>";
            echo "<td>{$row['updated_at']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    if ($_SESSION['role'] == 'admin') {
        header("Location: admin.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}


?>