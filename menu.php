<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'connectDB.php';

$loggedIn = isset($_SESSION['username']);
$user = $loggedIn ? $_SESSION['username'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css"/>
    <title>Document</title>
</head>

<body>
    <div class="nav">
    <a href="login.php">Login / Register</a>
    <a href="clothes.php">Clothes</a> 
    <a href="neces.php">Necessities</a> 
    <a href="orna.php">Ornaments</a> 
    <a href="cart.php">Cart</a> 
    
</div>
<div style="
    text-align: right;
    padding: 10px 20px;
    font-size: 14px;
">
    <?php if ($loggedIn): ?>
        <span style="
            display: inline-block;
            padding: 6px 14px;
            background: #e6f7ff;
            border-radius: 6px;
            margin-right: 6px;
            font-size: 25px;
        ">
            Welcome, <?php echo $user; ?>
        </span>

        <a href="logout.php" style="
            display: inline-block;
            padding: 6px 14px;
            background: #ff4d4f;
            color: white;
            border-radius: 6px;
            text-decoration: none;
            font-size: 25px;
        ">
            Logout
        </a>
    <?php else: ?>
        <span style="
            display: inline-block;
            padding: 6px 14px;
            background: #f6ffed;
            border-radius: 6px;
        ">
            Please Login
        </span>
    <?php endif; ?>
</div>
</body>
</html>
