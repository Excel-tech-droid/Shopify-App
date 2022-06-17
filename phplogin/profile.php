<?php
session_start();
// of is not logged  in redirect to the login page
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}
$db_host = 'localhost';
$db_user = 'root';
$db_pass = 'excel123';
$db_name = 'login';

$con = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (mysqli_connect_errno()) {
    exit('failed to connect to mysql: ' . mysqli_connect_error());
}

$stmt = $con->prepare('SELECT password,email FROM accounts WHERE id = ?');
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password, $email);
$stmt->fetch();
$stmt->close();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="fontawesome-free/css/all.min.css">
    <title>Profile Page</title>
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
        <h2>Profile Page</h2>
        <div>
            <p>Your account details are below: </p>
            <table>
                <tr>
                    <td>Username:</td>
                    <td><?=$_SESSION['name']; ?></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><?=$password;?></td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><?=$email;?></td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>