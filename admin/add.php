<?php

session_start();
//if the user is not logged in redirect to the login page.... 
if (!isset($_SESSION['adminloggedin'])) {
    header('Location: login.php');
    exit;
}
include('../config/db_connect.php');


$product_name = $product_pic = $product_desc = $product_price = "";


$errors = array('product_name' => '', 'product_pic' => '', 'product_desc' => '', 'product_price' => '');






if (isset($_FILES['product_pic'], $_POST['product_name'], $_POST['product_desc'], $_POST['product_price'])) {

    //check product picture
    $target_dir = 'images/';
    // path of the new uploaded image
    $product_pic = $target_dir . basename($_FILES['product_pic']['name']);

    // check to make sure the image is valid
    if (!empty($_FILES['product_pic']['tmp_name']) && getimagesize($_FILES['product_pic']['tmp_name'])) {
        if (file_exists($product_pic)) {
            $errors['product_pic'] = 'Image already exists, please choose another or rename that image. ';
        } elseif ($_FILES['product_pic']['size'] > 500000) {
            $errors['product_pic'] = 'Image file size too large please choose an image less than 500kb.';
        } else {
            move_uploaded_file($_FILES['product_pic']['tmp_name'], $product_pic);
        }
    } else {
        $errors['product_pic'] = 'Please choose an image file';
    }


    //check product name
    if (empty($_POST['product_name'])) {
        $errors['product_name'] = "A product name is required <br/>";
    } else {
        $product_name = $_POST['product_name'];
        if (!preg_match('/^[a-zA-Z0-9\s]+$/', $product_name)) {
            $errors['product_name'] = 'Product must be letters, numbers and spaces only';
        }
    }
    // check product description
    if (empty($_POST['product_desc'])) {
        $errors['product_desc'] = "The product description is required <br/>";
    } else {
        $product_desc = $_POST['product_desc'];
        // if (!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $product_desc)) {
        //       $errors['product_desc'] = 'Product description must be letters, numbers and spaces only';
        // }
    }

    //check product picture
    if (empty($_POST['product_price'])) {
        $errors['product_price'] = "A price is required <br/>";
    } else {
        $product_price = $_POST['product_price'];
        if (!preg_match('/^[0-9\s]+$/', $product_price)) {
            $errors['product_price'] = 'Price must be numbers and spaces only';
        }
    }

    if (array_filter($errors)) {
        //echo 'errors in the form';
    } else {

        move_uploaded_file($_FILES['product_pic']['tmp_name'], $product_pic);

        $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
        $product_price = mysqli_real_escape_string($conn, $_POST['product_price']);

        //create sql
        $sql = "INSERT INTO products(product_name, product_pic, product_desc, product_price) VALUES( '$product_name', '$product_pic', '$product_desc' , '$product_price' )";

        // save to db and check
        if (mysqli_query($conn, $sql)) {
            //success
            header('Location: adminpage.php');
        } else {
            //error
            echo 'query error:' . mysqli_error($conn);
        }

        //echo 'the form is valid';
        header('Location: adminpage.php');
    }
}

?>

<?php include('admintemplate/header.php') ?>

<div class="container body-add mt-3 card">

    <h1 class="card-header">Add a Product</h1>


    <div class="row">

        <div class="image col-xs-12 col-sm-6">
            <img class="img-fluid" src="../images/upload.png" alt="upload">
        </div>
        <div class="add col-xs-12 col-sm-6 ">

            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">

                <div class="input-group mb-3">
                    <label class="input-group-text" for="title"><i class="fas fa-shopping-bag"></i></label>

                    <input class="form-control" type="text" value="<?php echo htmlspecialchars($product_name); ?>" name="product_name" id="product_name" placeholder="Product name">
                    <div class="text-danger error"><?php echo $errors['product_name']; ?></div>
                </div>


                <div class="input-group mb-3">
                    <label class="input-group-text" for="product_pic"><i class="fas fa-image"></i></label>

                    <input class="image form-control" type="file" accept="image/*" name="product_pic" id="product_pic" placeholder="Product picture">
                    <div class="text-danger error"><?php echo $errors['product_pic']; ?></div>

                </div>

                <div class="input-group mb-3">
                    <label class="input-group-text" for="desc"><i class="fas fa-shopping-bag"></i></label>

                    <input class="form-control" type="text" value="<?php echo htmlspecialchars($product_desc); ?>" name="product_desc" id="product_desc" placeholder="Product description">
                    <div class="text-danger error"><?php echo $errors['product_desc']; ?></div>
                </div>

                <div class="input-group mb-3">
                    <label class="input-group-text" for="product_price"><i class="fas fa-dollar-sign"></i></label>

                    <input class="form-control" type="text" value="<?php echo htmlspecialchars($product_price); ?>" name="product_price" id="product_price" placeholder="Product price">
                    <div class="text-danger error"><?php echo $errors['product_price']; ?></div>
                </div>


                <input type="submit" value="submit" name="submit">

            </form>
        </div>

    </div><!-- row -->
</div><!-- content container -->


<?php include('admintemplate/footer.php') ?>