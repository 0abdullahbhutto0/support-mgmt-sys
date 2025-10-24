<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LiveSupport Admin</title>
</head>

<body>

</body>

</html>

<?php
session_start();
include("database.php");
if ($_SESSION['logged_in'] == 'true') {
    if ($_SESSION['role'] == 'admin') {
        echo "Hello Admin";
    }else{
        echo "User doesnt have admin privileges";
        echo "<a href='user.php'>Go back to User Page</a>";
    }
} else {
    header("Location: index.php");
    exit();
}



?>