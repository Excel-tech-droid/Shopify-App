<?php
session_start();
if (!isset($_SESSION['userloggedin'])) {
    header('Location: login.php');
    exit;
}

include('config/db_connect.php');
$id = $_SESSION['id'];

// make sql
$sql = "SELECT * FROM users WHERE id = $id";
// get the query result 
$result = mysqli_query($conn, $sql);

// fetch in array format
$user = mysqli_fetch_assoc($result);

mysqli_free_result($result);


// Profile Upload Pic 

$user_pic = "";
$errors = array('user_pic' => '');
if (isset($_FILES['user_pic'])) {

    //check product picture
    $target_dir = 'user-images/';
    // path of the new uploaded image
    $user_pic_dir = $target_dir . basename($_FILES['user_pic']['name']);
    $user_pic =  basename($_FILES['user_pic']['name']);

    // check to make sure the image is valid
    if (!empty($_FILES['user_pic']['tmp_name']) && getimagesize($_FILES['user_pic']['tmp_name'])) {

        if ($_FILES['user_pic']['size'] > 500000) {
            $errors['user_pic'] = 'Image file size too large please choose an image less than 500kb.';
        } else {
            move_uploaded_file($_FILES['user_pic']['tmp_name'], $user_pic_dir);
        }
    }



    if (array_filter($errors)) {
        //echo 'errors in the form';
    } else {
        $oldPic = './user-images/' . $user['user_pic'];
        if ($oldPic !== './user-images/default-user.png') {
            unlink($oldPic);
        }
        move_uploaded_file($_FILES['user_pic']['tmp_name'], $user_pic_dir);

        //create sql
        $sql2 = "UPDATE users SET user_pic ='$user_pic' WHERE id = $id ";

        // save to db and check
        if (mysqli_query($conn, $sql2)) {
            //success
            header('Location: profile.php');
        } else {
            //error
            echo 'query error:' . mysqli_error($conn);
        }

        //echo 'the form is valid';
        header('Location: profile.php');
    }
}

mysqli_close($conn);
?>

<?php include('templates/header.php'); ?>
<h1 class="card-header text-center alert alert-info mb-2">Profile</h1>

<div class="container">
    <div class="row">
        <div class="col">
            <h4 class="">Username: <?php echo $_SESSION['name']; ?></h4>
            <h4 class="">Email: <?php echo  $user['email']; ?></h4>
        </div>

        <div class="col">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                <label class="image" for="user_pic"><img src="user-images/<?php echo $user['user_pic']; ?>" alt="user pic"></label>
                <input class="hidden" type="file" name="user_pic" id="user_pic" placeholder="Product picture">
                <div class="text-danger error"><?php echo $errors['user_pic']; ?></div>
                <input type="submit" value="Update Pic" name="submit" class="btn btn-primary">
            </form>

        </div>


    </div>
</div>


<?php



?>