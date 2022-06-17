<?php
session_start();
//if the user is not logged in redirect to the login page....
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="fontawesome-free/css/all.min.css">
    <title>Home Page</title>
</head>

<body class="loggedin">
    <nav class="navtop">
        <div>
            <h1>Shopify</h1>
            <a href="profile.php"><i class="fas fa-user-circle">Profile</i></a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
        </div>
    </nav>
    <div class="content">
        <h2>Home Page</h2>
        <p>Welcome back, <?= $_SESSION['name'] ?>!</p>
    </div>
</body>

</html>