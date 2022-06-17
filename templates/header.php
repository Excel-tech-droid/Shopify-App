<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopify</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <!-- owl carousel-->
    <link rel="stylesheet" href="vendor/owl.carousel/assets/owl.carousel.css">
    <link rel="stylesheet" href="vendor/owl.carousel/assets/owl.theme.default.css">
    <link rel="stylesheet" href="css/extra.css">
    <link href="images/shopify-icon.png" rel="icon">
</head>

<body>
    <?php
    if (isset($_SESSION['userloggedin'])) {
        include('config/db_connect.php');
        $id = $_SESSION['id'];
        // make sql
        $sql = "SELECT * FROM users WHERE id = $id";
        // get the query result 
        $result = mysqli_query($conn, $sql);

        // fetch in array format
        $user = mysqli_fetch_assoc($result);

        mysqli_free_result($result);
        $userpic = '<img class="prof-pic" src="user-images/ {$user[\'user_pic\']}" alt="user pic">';
    } else {
        $userpic = '';
    }
    include('functions.php');
    ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <!---------->
            <a class="navbar-brand" href="index.php">

                <h3 class="text-primary"><i class="fas fa-store fa-spin"></i> Shopify</h3>
            </a>

            <span class="navbar-text ms-auto"></span>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="#navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-auto">
                    <li class="nav-item"><a href="index.php" class="nav-link"><i class="fas fa-home fa-lg"></i>Home</a></li>
                    <li class="nav-item"><a href="products.php" class="nav-link"><i class="fas fa-shopping-bag fa-lg"></i>Products</a></li>
                    <li class="nav-item"><a href="cart.php" class="nav-link"><i class="fas fa-cart-plus position-relative py-1 py-sm-0">Cart <?php if (isset($_SESSION['cart'])) { ?><span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success"><?php echo count($_SESSION['cart']); ?><span class="visually-hidden">Number of items</span></span><?php } ?></i></a></li>
                    <li class=" nav-item"><a href="profile.php" class="nav-link"><i class="fas fa-user-circle fa-lg"></i>Profile</a></li>
                    <li class="nav-item"><a href="login.php" class="nav-link">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
                    <li><a class="logout" href="phplogin/logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
                </ul>
            </div>
            <a class="navbar-brand" href="profile.php">
                <?php if (isset($_SESSION['userloggedin'])) { ?>
                    <img class="prof-pic" src="user-images/<?php echo $user['user_pic']; ?>" alt="user pic">
                <?php } ?>
            </a>

        </div>
    </nav>

    <body>
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="js/active.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/front.js"></script>
        <script src="vendor/owl.carousel/owl.carousel.min.js"></script>
        <script src="vendor/owl.carousel2.thumbs/owl.carousel2.thumbs.js"></script>