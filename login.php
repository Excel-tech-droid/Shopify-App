<?php

session_start();
include('config/db_connect.php');
$username = '';
$errors = array('username' => '', 'password' => '');
// checking if form i submitted
if (isset($_POST['username'], $_POST['password'])) {
    $username = $_POST['username'];
    //preventing sql injection
    if ($stmt = $conn->prepare('SELECT id, password FROM users where username = ? ')) {
        $stmt->bind_param('s', $_POST['username']);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $password);
            $stmt->fetch();

            if ($_POST['password'] === $password) {

                session_regenerate_id();
                $_SESSION['userloggedin'] = TRUE;
                $_SESSION['name'] = $_POST['username'];
                $_SESSION['id'] = $id;
                header('Location: index.php');
            } else {
                $errors['password'] =   'Incorrect password!';
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
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Shopify Login</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Font Awesome CSS-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="css/style.default.css" id="theme-stylesheet">
    <!-- Favicon-->
    <link href="images/shopify-icon.png" rel="icon">
</head>

<body>
    <div class="page login-page">
        <div class="container d-flex align-items-center">
            <div class="form-holder has-shadow">
                <div class="row">
                    <!-- Logo & Information Panel-->
                    <div class="col-lg-6">
                        <div class="info d-flex align-items-center">
                            <div class="content">
                                <div class="logo">
                                    <h1>Login</h1>
                                </div>
                                <p>Login into your shopify account</p>
                                <p class=" mt-5">Return to<big> <a class="text-info text-bold" href="index.php"><i class="fas fa-home"></i> Homepage</a></big></p>
                            </div>
                        </div>
                    </div>
                    <!-- Form Panel -->
                    <div class="col-lg-6 bg-white">
                        <div class="form d-flex align-items-center">
                            <div class="content">
                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-validate">
                                    <div class="form-group">
                                        <input id="login-username" type="text" value="<?php echo htmlspecialchars($username); ?>" name="username" required data-msg="Please enter your username" class="input-material">
                                        <label for="login-username" class="label-material"><i class="fas fa-user"></i> User Name</label>
                                    </div>
                                    <div class="text-danger error"><?php echo $errors['username']; ?></div>

                                    <div class="form-group">
                                        <input id="login-password" type="password" name="password" required data-msg="Please enter your password" class="input-material">
                                        <label for="login-password" class="label-material"><i class="fas fa-lock"></i> Password</label>
                                    </div>
                                    <div class="text-danger error"><?php echo $errors['password']; ?></div>
                                    <button id="login" type="submit" name="registersubmit" class="btn btn-primary" value="submit">Login</button>
                                </form><a href="#" class="forgot-pass">Forgot Password?</a><br><small>Do not have an account? </small><a href="register.php" class="signup">Signup</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyrights text-center">
            <p>Developed by <a href="https://excel.com" class="external">Excel Okeniyi</a>
            </p>
        </div>
    </div>
    <!-- JavaScript files-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper.js/umd/popper.min.js"> </script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/jquery-validation/jquery.validate.min.js"></script>
    <!-- Main File-->
    <script src="js/front.js"></script>
</body>

</html>