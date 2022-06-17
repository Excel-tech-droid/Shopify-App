<?php


session_start();
//if the user is not logged in redirect to the login page....
if (!isset($_SESSION['adminloggedin'])) {
    header('Location: login.php');
    exit;
}
include('../config/db_connect.php');

// write query for all pizzas
$sql = 'SELECT product_name, product_pic, product_desc, product_price, id FROM products ORDER BY added_at';
// make query and get result

$result = mysqli_query($conn, $sql);
// fetch the resulting rows as an array 
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);

// free result from memory
mysqli_free_result($result);

// close connection
mysqli_close($conn);
 

?>
<!DOCTYPE html>
<html lang="en">
<?php include('admintemplate/header.php') ?>
<h4 class="text-danger text-center">Products!</h4>
<div class="container">
    <div class="row">

        <?php foreach ($products as $product) { ?>

            <div class="col-xs-6 col-sm-6 col-md-4  ">
                <div class="cards text-center">

                    <div class="pop">
                        <a href="#">
                            <img class="icon img-fluid" src="<?= $product['product_pic'] ?>" alt="<?= $product['product_desc'] ?>" data-id="<?= $product['id'] ?>" data-title="<?= $product['product_name'] ?>" width="200" height="200">

                        </a>
                    </div>


                    <h6>
                        <center>
                            <h4><?php echo htmlspecialchars($product['product_name']);  ?></h4>
                        </center>
                    </h6>

                    <div class="cards text-center">
                        <h6>$<?php
                                echo htmlspecialchars($product['product_price']); ?>
                        </h6>

                    </div>
                    <div class="car">
                        <center><a class="btn btn-secondary mb-2" href="details.php?id=<?php echo $product['id']; ?>">more info</a></center>
                    </div>
                </div>


            </div>


        <?php } ?>



    </div>
</div>
<div class="image-popup"></div>

<script>
    //Container we'll use to show and image
    let image_popup = document.querySelector('.image-popup');
    //Loop each image so that we can have the on click event
    document.querySelectorAll('.pop a').forEach(img_link => {
        img_link.onclick = e => {
            e.preventDefault();
            let img_meta = img_link.querySelector('img');
            let img = new Image();
            img.onload = () => {
                //Create pop out image
                image_popup.innerHTML = `
                <div class="con">
                <h3>${img_meta.dataset.title}</h3>
                <p>${img_meta.alt}</p>
                <img src="${img.src}" width="${img.width}" height="${img.height}">
                <a href="details.php?id=${img_meta.dataset.id}" class="trash" title="Delete Image"><i class="fas fa-trash fa-xs"></i></a>
                </div>
                `;
                image_popup.style.display = 'inline-flex';

            };
            img.src = img_meta.src;
        };

    });
    // Hide the image popup container if user clicks outside the image
    image_popup.onclick = e => {
        if (e.target.className == 'image-popup') {
            image_popup.style.display = "none";
        }
    };
</script>


<?php include('admintemplate/footer.php') ?>

</html>