<?php
include('header.php');
// close connection
mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Password Reset</title>
</head>

<body>
    <div class="container">
        <h4 class="text-center my-3 ">Welcome to NPS Registeration </h4>
        <section id="hero" class="d-flex align-items-center">

            <div class="container">
                <div class="row">
                    <div class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1" data-aos="fade-up" data-aos-delay="200">
                        <h1>Password Reset</h1>

                        <h5> We sent an email to <b> <?php echo $_GET['email']; ?> </b> to help recover your email</h5>
                        <p>Please login to your gmail and click on the link to we sent to reset your password</p>
                    </div>
                    <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="200">
                        <img src="./img/email.png" class="img-fluid animated" alt="image1">
                    </div>
                </div>
            </div>

        </section>
    </div>
</body>

</html>