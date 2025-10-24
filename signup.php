<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LiveSupport Sign Up</title>
</head>
<body>
    <form action="signup.php" method="post">
        <h1>LiveSupport Sign Up</h1>
        <label>Name:</label>
        <input type="text" name="name">
        <label>Username:</label>
        <input type="text" name="username">
        <label>Password:</label>
        <input type="password" name="password">
        <input type="submit" name="submit" value="Sign In">
        <input type="submit" name="login" value="Go to Login">
    </form>
</body>
</html>


<?php
session_start();
include("database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    if (empty($username) || empty($password)||empty($name)) {
        echo "Please enter all the credentials.";
    } else {
        $sql = "INSERT INTO users(name, username, password, role) VALUES('$name','$username', '$password', 'user')";
        try {
            mysqli_query($conn, $sql);
            echo "Registered!";
            $sql_id = "SELECT id FROM users WHERE username='{$username}";
            $result = mysqli_query($conn, $sql_id);
            $row=mysqli_fetch_assoc($result);
            $id=$row['id'];
            $_SESSION['name'] = $name;
            $_SESSION['username'] = $username;
            $_SESSION['logged_in'] = true;
            $_SESSION['role'] = 'user';
            $_SESSION['id'] = $id;
            header("Location: user.php");
            exit();
        } catch (mysqli_sql_exception) {
            echo "Username Already taken.";
        }
    }
}

if (isset($_POST['login'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

mysqli_close($conn);

?>