<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LiveSupport Admin</title>
    <link rel='stylesheet' href='auth.css'>
    <script src="https://kit.fontawesome.com/37d0d17982.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class='form-container'>
        <form action="adminlogin.php" method="post">
            <h1><i class='fa-solid fa-user'></i><br>LiveSupport<br> Admin Log In</h1>
            <label>Username:</label>
            <input type="text" name="username">
            <label>Password:</label>
            <input type="password" name="password">
            <input type="submit" name="submit" value="Login">
            <input type="submit" name="login" value="Go to User Log in">
        </form>
    </div>
</body>

</html>

<?php
session_start();
if (isset($_SESSION['logged_in'])) {
    $_SESSION['logged_in'] = false;
}
include("database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    if (empty(trim($username)) || empty(trim($password))) {
        echo "<h2 class='resolved-head'>Please enter all the credentials.</h2>";
    } else {

        $sql = "SELECT password, name, id FROM users WHERE username = '$username'";
        $result =  mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        if (!isset($row['password'])) {
            echo "<h2 class='resolved-head'>Invalid Admin Info</h2>";
            exit();
        }
        $pass = $row['password'];
        $name = $row['name'];
        $id = $row['id'];

        #var_dump($pass);
        if ($password == $pass) {
            echo "Logged IN";
            $_SESSION['username'] = $username;
            $_SESSION['name'] = $name;
            $_SESSION['logged_in'] = true;
            $_SESSION['id'] = $id;
            $_SESSION['role'] = 'admin';
            header("Location: user.php");
            exit();
        } else {
            echo "<h2 class='resolved-head'>Invalid Admin Info.</h2>";
        }
    }
}


if (isset($_POST['login'])) {
    session_destroy();
    header("Location: login.php");
}

mysqli_close($conn);

?>