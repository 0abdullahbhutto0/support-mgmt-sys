<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LiveSupport Admin</title>
</head>
<body>
    <form action="adminlogin.php" method="post">
        <h1>LiveSupport Admin Log In</h1>
        <label>Username:</label>
        <input type="text" name="username">
        <label>Password:</label>
        <input type="password" name="password">
        <input type="submit" name="submit" value="Login">
        <input type="submit" name="login" value="Go to User Log in">
    </form>
</body>
</html>

<?php
session_start();
if (isset($_SESSION['logged_in'])) {
    $_SESSION['logged_in']=false;
}
include("database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (empty($username) || empty($password)) {
        echo "Please enter all the credentials.";
    } else {

        $sql = "SELECT password, name FROM users WHERE username = '$username'";
        $result =  mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        if (!isset($row['password'])) {
            echo "Invalid Admin Info";
            exit();
        }
        $pass = $row['password'];
        $name = $row['name'];

        #var_dump($pass);
        if ($password == $pass) {
            echo "Logged IN";
            $_SESSION['username'] = $username;
            $_SESSION['name'] = $name;
            $_SESSION['logged_in'] = true;
            $_SESSION['role'] = 'admin';
            header("Location: user.php");
            exit();
        } else {
            echo "Invalid Admin Info.";
        }
    }
}


if (isset($_POST['login'])) {
    session_destroy();
    header("Location: login.php");
}

mysqli_close($conn);

?>