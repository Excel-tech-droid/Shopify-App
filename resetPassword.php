 <?php
    session_start();
    include('header.php');

    if ($user['role'] !== 'admin') {
        header('Location: login.php');
        exit;
    }

    $password = $confirm_password = "";
    $errors = array('confirm_password' => '', 'password' => '');

    if (isset($_POST['resetPassword'])) {

        //check password
        if (empty($_POST['password'])) {
            $errors['password'] = "Please input your password<br/>";
        } else {
            $password = $_POST['password'];
            if (!preg_match('/^[a-zA-Z0-9\s]+$/', $password)) {
                $errors['password'] = 'Price must be letters, numbers and spaces only';
            }
        }

        if (empty($_POST['confirm_password'])) {
            $errors['confirm_password'] = "Please confirm your password<br/>";
        } else {
            $confirm_password = $_POST['confirm_password'];
            if ($confirm_password !== $password) {
                $errors['confirm_password'] = 'Passwords do not match';
            }
        }


        if (array_filter($errors)) {
            //echo 'errors in the form';
        } else {
            if ($stmt = $conn->prepare('SELECT id, password FROM users where username = ? ')) {
                $stmt->bind_param('s', $_POST['username']);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows > 0) {

                    $errors['username'] = "This username already exists!. Choose another<br>";
                } else {
                    $password = mysqli_real_escape_string($conn, $_POST['password']);
                    $password = md5($password);

                    //create sql
                    $sql = "INSERT INTO users( password) VALUES( '$username', '$email', '$role', '$password' )";

                    // save to db and check
                    if (mysqli_query($conn, $sql)) {
                        //success
                        header('Location: login.php');
                    } else {
                        //error
                        echo 'query error:' . mysqli_error($conn);
                    }


                    //echo 'the form is valid';

                    header('Location: login.php');
                }
            }
        }
    } // end of POST check

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
                                     <h1>Please Enter Your Valid password</h1>
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
                                         <input value="<?php echo htmlspecialchars($password); ?>" id="reset-password" type="password" name="password" required data-msg="Please enter your New password" class="input-material">
                                         <label for="reset-password" class="label-material">New Password </label>
                                         <div class="text-danger"><?php echo $errors['password']; ?></div>
                                     </div>
                                     <div class="form-group">
                                         <input value="<?php echo htmlspecialchars($confirm_password); ?>" id="reset-password" type="password" name="confirm_password" required data-msg="Please confirm your password" class="input-material">
                                         <label for="reset-password" class="label-material">Confirm Password</label>
                                         <div class="text-danger"><?php echo $errors['confirm_password']; ?></div>
                                     </div>

                                     <button id="reset" type="submit" name="resetPassword" class="btn btn-success" value="submit">Reset</button>
                                 </form>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
         <div class="copyrights text-center">
             <p>Design by <a href="https://bootstrapious.com/p/admin-template" class="external">Bootstrapious</a>
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