<?php
session_start();
include('config/db_connect.php');

// write query for all products
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
<?php include('templates/header.php'); ?>
<h4 class="alert-primary text-center">Products!</h4>
<div class="container">
    <div class="row">

        <?php foreach ($products as $product) { ?>

            <div class="col-xs-12 col-sm-6 col-md-4 ">
                <div class="cards text-center ">
                    <div class="pop">
                        <a href="#">
                            <img class="icon img-fluid" src="admin/<?= $product['product_pic'] ?>" alt="<?= $product['product_desc'] ?>" data-id="<?= $product['id'] ?>" data-title="<?= $product['product_name'] ?>" width="200" height="200">

                        </a>
                    </div>
                    <h4><?php echo htmlspecialchars($product['product_name']);  ?></h4>


                    <div class="cards text-center">
                        <h6>$<?php
                                echo htmlspecialchars($product['product_price']); ?>
                        </h6>

                    </div>
                    <form method="post" action="cart.php?action=add&id=<?php echo $product["id"]; ?>">
                        <input type="text" name="quantity" value="1" class="form-control m-2">

                        <input type="hidden" name="hidden_pic" value="<?php echo $product['product_pic']; ?>">


                        <input type="hidden" name="hidden_name" value="<?php echo htmlspecialchars($product['product_name']); ?>">

                        <input type="hidden" name="hidden_price" value="<?php echo htmlspecialchars($product['product_price']); ?>">

                        <input type="submit" name="add_to_cart" class="btn btn-secondary mb-2 addto" value="Add to Cart">
                    </form>
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
                <a href="#" class="trash" title="Add to Cart"><i class="fas fa-plus fa-xs"></i></a>
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

<?php include('templates/footer.php') ?>

</html>