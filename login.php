<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LiveSupport Log In</title>
</head>

<body>
    <form action="login.php" method="post">
        <h1>LiveSupport Log In</h1>
        <label>Username:</label>
        <input type="text" name="username">
        <label>Password:</label>
        <input type="password" name="password">
        <input type="submit" name="submit" value="Login">
        <input type="submit" name="signup" value="Go to Sign Up">
    </form>
</body>

</html>

<?php
session_start();
if (isset($_SESSION['logged_in'])) {
    $_SESSION['logged_in'] = false;
}
include("database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (empty($username) || empty($password)) {
        echo "Please enter all the credentials.";
    } else {
        $sql = "SELECT password, name, id, role FROM users WHERE username = '$username'";
        $result =  mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        #var_dump($pass);
        if (!isset($row['password'])) {
            echo "Invalid username";
            exit();
        }
        $pass = $row['password'];
        $name = $row['name'];
        $id=$row['id'];
        $role=$row['role'];
        if ($password == $pass) {
            echo "Logged IN";
            $_SESSION['username'] = $username;
            $_SESSION['name'] = $name;
            $_SESSION['logged_in'] = true;
            $_SESSION['role'] = $role;
            $_SESSION['id'] = $id;
            header("Location: user.php");
            exit();
        } else {
            echo "Invalid Login Info.";
        }
    }
}


if (isset($_POST['signup'])) {
    session_destroy();
    header("Location: signup.php");
}

mysqli_close($conn);

?>