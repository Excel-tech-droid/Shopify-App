<?php
session_start();
include('./config/db_connect.php');
$errors = array('email' => '');
$email = '';
// checking if form is submitted
if (isset($_POST['email'])) {
    //check email
    if (empty($_POST['email'])) {
        $errors['email'] = "An email is required <br/>";
    } else {
        $email = $_POST['email'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'email must be a valid email address';
        }
    }

    if (array_filter($errors)) {
        //echo 'errors in the form';
    } else {
        $query = "SELECT email, token FROM users WHERE email = '$email' ";
        $results = mysqli_query($conn, $query);
        if (mysqli_num_rows($results) > 0) {
            $token = bin2hex(random_bytes(50));
            if ($results['token'] === '') {
                $sql3 = "INSERT INTO users(token) VALUES('$token')";
                $results = mysqli_query($conn, $sql3);
            } else {
                $sql3 = "UPDATE users SET token = '$token' WHERE email = $email";
                $results = mysqli_query($conn, $sql3);
            }

            //Send email to user with the token in alink they can click on
            $to = $email;
            $subject = "Reset your password on NPS.com";
            $msg = "Hi there👋👋, click on this <a href=\"resetPassword.php?token=" . $token . "\">link</a> to reset your password on our site";
            $msg = wordwrap($msg, 70);
            $headers = "From: npsadmin@gmail.com";
            mail($to, $subject, $msg, $headers);
            header('location: pending.php?email=' . $email);
        } else {
            $errors['email'] = 'Sorry, no user exists with that email';
        }
    }
}
mysqli_close($conn);

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>NPS Reset Password</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
    <!-- Fontastic Custom icon font-->
    <link rel="stylesheet" href="css/fontastic.css">
    <!-- Google fonts - Poppins -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,700">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="css/style.default.css" id="theme-stylesheet">

    <!-- Favicon-->
    <link href="img/nps-icon.jpg" rel="icon">
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
                                    <h1>Please Enter Your Valid Email</h1>
                                </div>
                                <p></p>
                            </div>
                        </div>
                    </div>
                    <!-- Form Panel    -->
                    <div class="col-lg-6 bg-white">
                        <div class="form d-flex align-items-center">
                            <div class="content">
                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-validate">
                                    <div class="form-group">
                                        <input value="<?php echo htmlspecialchars($email); ?>" id="login-email" type="text" name="email" required data-msg="Please enter your email" class="input-material">
                                        <label for="login-email" class="label-material">Email</label>
                                        <div class="text-danger error"><?php echo $errors['email']; ?></div>
                                    </div>

                                    <button id="login" type="submit" name="resetEmail" class="btn btn-success" value="submit">Reset</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyrights text-center">
            <p>Design by <a href="https://bootstrapious.com/p/admin-template" class="external">Bootstrapious</a>
                <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
            </p>
        </div>
    </div>
    <!-- JavaScript files-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper.js/umd/popper.min.js"> </script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/jquery-validation/jquery.validate.min.js"></script>
    <!-- Main File-->
    <script src="js/front.js"></script>
</body>

</html>