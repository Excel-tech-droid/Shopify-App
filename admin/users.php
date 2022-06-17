<?php

session_start();
//if the user is not logged in redirect to the login page....
if (!isset($_SESSION['adminloggedin'])) {
    header('Location: login.php');
    exit;
}
include('../config/db_connect.php');

// write query for all pizzas
$sql = 'SELECT username, email, user_pic, registered_on, id FROM users ORDER BY id';
// make query and get result

$result = mysqli_query($conn, $sql);
// fetch the resulting rows as an array 
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);

// free result from memory
mysqli_free_result($result);

// close connection
mysqli_close($conn);





?>


<?php include('admintemplate/header.php') ?>




<section id="users" class="users">
    <div class="container">
        <div class="section-title">
            <h2 class="alert alert-primary
           text-center">Users</h2>
            <p>Magnam dolores commodi suscipit. </p>
        </div>

        <div class="row">
            <?php foreach ($users as $user) { ?>


                <div class="col-lg-6">
                    <div class="member d-flex align-items-start">
                        <div class="pic"><img src="../user-images/<?php echo $user['user_pic']; ?>" class="img-fluid" alt=""></div>
                        <div class="member-info">
                            <h4><?php echo htmlspecialchars($user['username']);  ?></h4>
                            <span>Email: <?php
                                            echo htmlspecialchars($user['email']); ?></span>
                            <p>
                                <?php echo htmlspecialchars($user['username']);  ?>
                                resgistered with shopify on <?php echo htmlspecialchars($user['registered_on']);  ?>
                            </p>
                            <div class="social">
                                <a href=""><i class="fas fa-envelope"></i></a>
                                <a href=""><i class="fab fa-facebook-f"></i></a>
                                <a href=""><i class="fab fa-instagram"></i></a>
                                <a href=""><i class="fab fa-linkedin"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>

    <?php } ?>



    </div>
    </div>
</section>


<?php include('admintemplate/footer.php') ?>