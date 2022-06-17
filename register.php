<?php
include('config/db_connect.php');


$username = $user_pic = $email = $password = "";


$errors = array('username' => '', 'email' => '', 'password' => '');




if (isset($_POST['registersubmit'])) {

  //check email
  if (empty($_POST['email'])) {
    $errors['email'] = "An email is required <br/>";
  } else {
    $email = $_POST['email'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors['email'] = 'email must be a valid email address';
    }
  }

  //check username
  if (empty($_POST['username'])) {
    $errors['username'] = "A username is required <br/>";
  } else {
    $username = $_POST['username'];
    if (!preg_match('/^[a-zA-Z0-9\s]+$/', $username)) {
      $errors['username'] = 'Username must be letters, numbers and spaces only';
    }
  }
  //check password
  if (empty($_POST['password'])) {
    $errors['password'] = "Please input your password<br/>";
  } else {
    $password = $_POST['password'];
    if (!preg_match('/^[a-zA-Z0-9\s]+$/', $password)) {
      $errors['password'] = 'Price must be letters, numbers and spaces only';
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
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $user_pic = mysqli_real_escape_string($conn, $_POST['user_pic']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $password = md5($password);

        //create sql
        $sql = "INSERT INTO users(username, email, user_pic,  password) VALUES( '$username', '$email', '$user_pic', '$password' )";

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
  <title>Shopify Registration</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="robots" content="all,follow">
  <!-- Bootstrap CSS-->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <!-- Font Awesome CSS-->
  <link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
  <!-- Fontastic Custom icon font-->
  <link rel="stylesheet" href="css/fontastic.css">
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
                  <h1>Shopify</h1>
                </div>
                <p>Please enter all information correctly.</p>
              </div>
            </div>
          </div>
          <!-- Form Panel    -->
          <div class="col-lg-6 bg-white">
            <div class="form d-flex align-items-center">
              <div class="content">

                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="form-validate">

                  <div class="form-group">
                    <input value="<?php echo htmlspecialchars($username); ?>" id="register-username" type="text" name="username" required data-msg="Please enter your username" class="input-material">
                    <label for="register-username" class="label-material">User Name</label>
                    <div class="text-danger"><?php echo $errors['username']; ?></div>
                  </div>

                  <div class="form-group">
                    <input value="<?php echo htmlspecialchars($email); ?>" id="register-email" type="email" name="email" required data-msg="Please enter a valid email address" class="input-material">
                    <label for="register-email" class="label-material">Email Address </label>
                    <div class="text-danger"><?php echo $errors['email']; ?></div>
                  </div>


                  <div class="form-group">
                    <input value="<?php echo htmlspecialchars($password); ?>" id="register-password" type="password" name="password" required data-msg="Please enter your password" class="input-material">
                    <label for="register-password" class="label-material">Password </label>
                    <div class="text-danger"><?php echo $errors['password']; ?></div>
                  </div>
                  <input type="hidden" value="default-user.png" name="user_pic">

                  <div class="form-group terms-conditions">
                    <input id="register-agree" name="registerAgree" type="checkbox" required value="1" data-msg="Your agreement is required" class="checkbox-template">
                    <label for="register-agree">Agree the terms and policy</label>
                  </div>
                  <div class="form-group">
                    <button id="register" type="submit" name="registersubmit" class="btn btn-primary" value="submit">Register</button>
                  </div>
                </form><small>Already have an account? </small><a href="login.php" class="signup">Login</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="copyrights text-center">
      <p>Design by <a href="https://bootstrapious.com" class="external">Bootstrapious</a>
        <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
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