<?php include 'connectDB.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css"/>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="header">
    <h1>Login</h1>
</div>
<?php include 'menu.php'; ?>
<div class="container">
    <div class="login-column">
        <h2>Login Member</h2>
        <form method="post" onsubmit="return checkLogin()">
            Username: <input type="text" name="username" maxlength="20"><br>
            Password: <input type="password" name="password" maxlength="20"><br>
            <button name="login">Submit</button>
        </form>
    </div>

    <div class="register-column">
        <h2>Register New Member</h2>
        <form method="post" onsubmit="return checkRegister()">
            Username: <input type="text" name="reg_user" maxlength="20"><br>
            Phone: <input type="number" name="phone" maxlength="20"><br>
            Password: <input type="password" name="reg_pwd" maxlength="20"><br>
            Confirm Password: <input type="password" name="reg_pwd2"><br>
            <div class="button-group">
                <button name="register">Submit</button>
                <button type="reset">Reset</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>





<?php
// Login
if (isset($_POST['login'])) {
    $u = $_POST['username'];
    $p = $_POST['password'];

    $sql = "SELECT * FROM members WHERE username='$u' AND password='$p'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['username'] = $u;
        echo "<script>alert('Login successful');location.href='clothes.php';</script>";
    } else {
        echo "<script>alert('Incorrect username or password');</script>";
    }
}

// Register
if (isset($_POST['register'])) {
    $u = $_POST['reg_user'];
    $phone = $_POST['phone'];
    $pwd = $_POST['reg_pwd'];
    $pwd2 = $_POST['reg_pwd2'];

    if ($pwd != $pwd2) {
         echo "<script>alert('Passwords do not match');</script>";
        exit;
    }

    $check = "SELECT * FROM members WHERE username='$u' OR phone='$phone'";
    $res = mysqli_query($conn, $check);

    if (mysqli_num_rows($res) > 0) {
        echo "<script>alert('Username or phone already exists');</script>";
        exit;
    }

    $sql = "INSERT INTO members(username, phone, password) VALUES('$u','$phone','$pwd')";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Registration successful');location.href='login.php';</script>";
    }
}
?>