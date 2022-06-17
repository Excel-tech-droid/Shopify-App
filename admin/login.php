<?php

session_start();
include('../config/db_connect.php');
$errors = array('username' => '', 'password' => '');
$username = '';
// checking if form is submitted
if (isset($_POST['username'], $_POST['password'])) {
    //preventing sql injection
    $username = $_POST['username'];
    if ($stmt = $conn->prepare('SELECT id, password FROM admin where username = ? ')) {
        $stmt->bind_param('s', $_POST['username']);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $password);
            $stmt->fetch();

            if ($_POST['password'] === $password) {

                session_regenerate_id();
                $_SESSION['adminloggedin'] = TRUE;
                $_SESSION['name'] = $_POST['username'];
                $_SESSION['id'] = $id;
                header('Location: adminpage.php');
            } else {
                $errors['password'] =  'Incorrect password!';
            }
        } else {
            $errors['username'] = 'Incorrect username!';
        }

        $stmt->close();
    }
}


mysqli_close($conn);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../vendor/fontawesome-free/css/all.min.css">
    <link href="../images/shopify-icon.png" rel="icon">
    <title>Shopify Admin Login</title>
</head>

<body class="login">
    <div class="login">
        <h1> Admin Login</h1>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="form-floating">
                <input class="form-control" type="text" value="<?php echo htmlspecialchars($username); ?>" name="username" placeholder="Username" id="username" required>
                <label for="username"> <i class="fas fa-user"></i>Username</label>
                <div class="text-danger error"><?php echo $errors['username']; ?></div>
            </div>



            <div class="form-floating">
                <input class="form-control" type="password" name="password" placeholder="Password" id="password" required>
                <label for="password"><i class="fas fa-lock"></i> Password</label>
                <div class="text-danger error"><?php echo $errors['password']; ?></div>
            </div>

            <input type="submit" value="Login">
        </form>
    </div>
</body>

</html>