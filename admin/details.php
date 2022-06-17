<?php

session_start();
//if the user is not logged in redirect to the login page....
if (!isset($_SESSION['adminloggedin'])) {
    header('Location: login.php');
    exit;
}

include('../config/db_connect.php');


// check get request id parameter
if (isset($_GET['id'])) {

    $id = mysqli_real_escape_string($conn, $_GET['id']);
    // make sql
    $sql = "SELECT * FROM products WHERE id = $id";
    // get the query result 
    $result = mysqli_query($conn, $sql);

    // fetch in array format
    $product = mysqli_fetch_assoc($result);

    mysqli_free_result($result);
    mysqli_close($conn);
}
if (isset($_POST['delete'])) {
    $id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);

    $sql2 = "SELECT * FROM products WHERE id = $id_to_delete";
    // get the query result 
    $result = mysqli_query($conn, $sql2);

    // fetch in array format
    $product = mysqli_fetch_assoc($result);

    mysqli_free_result($result);

    unlink($product['product_pic']);
    $sql = "DELETE FROM products WHERE id = $id_to_delete";

    if (mysqli_query($conn, $sql)) {
        // success
        header('Location: adminpage.php');
    } else {
        // failure
        echo 'query error: ' . mysqli_error($conn);
    }
};
?>

<!DOCTYPE html>
<html lang="en">
<?php include('admintemplate/header.php') ?>

<div class="container text-center">
    <?php if ($product) {  ?>
        <img class="icon" src="<?= $product['product_pic'] ?>" width="200" height="200">
        <h4><?php echo htmlspecialchars($product['product_name']); ?></h4>
        <p><?php echo htmlspecialchars($product['product_desc']); ?></p>
        <p><?php echo htmlspecialchars($product['product_price']); ?></p>
        <h5>Date added:</h5>
        <p><?php echo date($product['added_at']); ?></p>
        <!---- DELETE FORM----->
        <form class="delete" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
            <input type="hidden" name="id_to_delete" value="<?php echo $product['id']; ?>">
            <input type="submit" name="delete" value="Delete" class="btn btn-warning btn-sm">
        </form>



    <?php  } else { ?>
        <h3>No such product exists!</h3>
    <?php } ?>

</div>


<?php include('admintemplate/footer.php') ?>

</html>