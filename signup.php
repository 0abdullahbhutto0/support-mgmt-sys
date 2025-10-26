<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LiveSupport Sign Up</title>
    <link rel='stylesheet' href='auth.css'>
    <script src="https://kit.fontawesome.com/37d0d17982.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class='form-container'>
        <form action="signup.php" method="post">
            <h1><i class='fa-solid fa-user'></i><br>LiveSupport Sign Up</h1>
            <label>Name:</label>
            <input type="text" name="name">
            <label>Username:</label>
            <input type="text" name="username">
            <label>Password:</label>
            <input type="password" name="password">
            <input type="submit" name="submit" value="Sign In">
            <input type="submit" name="login" value="Go to Login">
        </form>
    </div>
</body>

</html>


<?php
session_start();
include("database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    if (empty($username) || empty($password) || empty($name)) {
        echo "<h2 class='resolved-head'>Please enter all the credentials.</h2>";
    } else {
        #echo $username;
        $sql = "INSERT INTO users(name, username, password, role) VALUES('{$_POST['name']}', '{$_POST['username']}', '{$_POST['password']}', 'user')";
        #die();
        try {
            $result = mysqli_query($conn, $sql);
            if ($result) {
                echo "Registered!";
            }
            #echo "Registered!";
            $sql_id = "SELECT id FROM users WHERE username='{$username}'";
            $result = mysqli_query($conn, $sql_id);
            $row = mysqli_fetch_assoc($result);
            $id = $row['id'];
            $_SESSION['name'] = $name;
            $_SESSION['username'] = $username;
            $_SESSION['logged_in'] = true;
            $_SESSION['role'] = 'user';
            $_SESSION['id'] = $id;
            header("Location: user.php");
            exit();
        } catch (mysqli_sql_exception) {
            echo "<h2 class='resolved-head'> Username Already taken.</h2>";
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