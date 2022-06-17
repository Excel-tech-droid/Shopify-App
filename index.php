<?php
session_start();
function displayProduct()
{ ?>
    <?php
    global $categorys;
    foreach ($categorys as $product) { ?>
        <div class="item">
            <div class="product">
                <div class="flip-container">
                    <div class="flipper">
                        <div class="front"><a href="details.php?id=<?php echo $product['id']; ?>"><img src="admin/<?= $product['product_pic'] ?>" alt="" class="img-fluid"></a></div>
                        <div class="back"><a href="details.php?id=<?php echo $product['id']; ?>"><img src="admin/<?= $product['product_pic'] ?>" alt="" class="img-fluid"></a></div>
                    </div>
                </div><a href="details.php?id=<?php echo $product['id']; ?>" class="invisible"><img src="images/camera lens.jpg" alt="" class="img-fluid"></a>
                <div class="text">
                    <h3><a href="details.php?id=<?php echo $product['id']; ?>"><?php echo htmlspecialchars($product['product_name']);  ?></a></h3>
                    <p class="price">
                        <del></del>$<?php
                                    echo htmlspecialchars($product['product_price']); ?>
                    </p>
                </div>
            </div>
            <!-- /.product-->
        </div>

        <!-- <form method="post" action="cart.php?action=add&id=<?php echo $product["id"]; ?>">
                    <input type="text" name="quantity" value="1" class="form-control m-2">
                    <input type="hidden" name="hidden_pic" value="<?php echo $product['product_pic']; ?>">
                    <input type="hidden" name="hidden_name" value="<?php echo htmlspecialchars($product['product_name']); ?>">
                    <input type="hidden" name="hidden_price" value="<?php echo htmlspecialchars($product['product_price']); ?>">
                    <input type="submit" name="add_to_cart" class="btn btn-secondary mb-2 addto" value="Add to Cart">
                </form> -->
<?php
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<?php include('templates/header.php'); ?>
<div class="home">
    <section id="hero" class="d-flex align-items-center">
        <div class="container">
            <h1>Welcome to <span class="cooltext">Shopify</span></h1>
            <h2>Shopify is one of the best online shopping facilities</h2>
            <h2>Get your favourite products here</h2>
            <a href="products.php" class="btn-get-started scrollto">Veiw Products</a>
        </div>
    </section>
</div>
<div class="container-fluid">
    <div class="row">

    </div>
</div>

<div id="all">
    <div id="content">
        <!--
        *** HOT PRODUCT SLIDESHOW ***
        _______________________________________________
        -->
        <div id="hot">
            <div class="box py-4">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="mb-0">Hot this week</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="product-slider owl-carousel owl-theme">
                    <?php
                    selectProduct('phone');
                    displayProduct();
                    ?>
                    <div class="item">
                        <div class="product">
                            <div class="flip-container">
                                <div class="flipper">
                                    <div class="front"><a href="detail.html"><img src="images/jordan shoe.jpg" alt="" class="img-fluid"></a></div>
                                    <div class="back"><a href="detail.html"><img src="images/jordan shoe.jpg" alt="" class="img-fluid"></a></div>
                                </div>
                            </div><a href="detail.html" class="invisible"><img src="images/jordan shoe.jpg" alt="" class="img-fluid"></a>
                            <div class="text">
                                <h3><a href="detail.html">White Blouse Armani</a></h3>
                                <p class="price">
                                    <del>$280</del>$143.00
                                </p>
                            </div>
                            <!-- /.text-->
                            <div class="ribbon sale">
                                <div class="theribbon">SALE</div>
                                <div class="ribbon-background"></div>
                            </div>
                            <!-- /.ribbon-->
                            <div class="ribbon new">
                                <div class="theribbon">NEW</div>
                                <div class="ribbon-background"></div>
                            </div>
                            <!-- /.ribbon-->
                            <div class="ribbon gift">
                                <div class="theribbon">GIFT</div>
                                <div class="ribbon-background"></div>
                            </div>
                            <!-- /.ribbon-->
                        </div>
                        <!-- /.product-->
                    </div>

                    <!-- /.product-slider-->
                </div>
                <!-- /.container-->
            </div>
            <!-- /#hot-->
            <!-- *** HOT END ***-->
        </div>
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