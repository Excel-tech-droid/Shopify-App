<?php
session_start();
if (!isset($_SESSION['userloggedin'])) {
    header('Location: login.php');
    exit;
}

include('config/db_connect.php');

// write query for all pizzas
$sql = 'SELECT product_name, product_pic, product_price, id FROM products ORDER BY added_at';
// make query and get result

$result = mysqli_query($conn, $sql);
// fetch the resulting rows as an array 
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);

// free result from memory
mysqli_free_result($result);

// close connection
mysqli_close($conn);


if (isset($_POST['add_to_cart'])) {
    if (isset($_SESSION['cart'])) {
        $item_array_id = array_column($_SESSION["cart"], "item_id");
        if (!in_array($_GET['id'], $item_array_id)) {
            $count = count($_SESSION["cart"]);
            $item_array = array(
                'item_id'            =>    $_GET["id"],
                'item_name'            =>    $_POST["hidden_name"],
                'item_image'        =>    $_POST["hidden_pic"],
                'item_price'        =>    $_POST["hidden_price"],
                'item_quantity'        =>    $_POST["quantity"]
            );
            $_SESSION["cart"][$count] = $item_array;
            echo '<script>
                const hideAlert = () => {
                    const el = document.querySelector(".alerts");
                    if (el) el.parentElement.removeChild(el);
                };
                const showAlert = (type, msg) => {
                    hideAlert();
                    const markup = `<div class="alerts alerts--${type}">${msg}</div>`;
                    document.querySelector("body").insertAdjacentHTML("afterbegin", markup);
                    window.setTimeout(hideAlert, 4000);
                };
                showAlert("success", "Item Added");
                </script>';
        } else {

            echo '<script>
                const hideAlert = () => {
                    const el = document.querySelector(".alerts");
                    if (el) el.parentElement.removeChild(el);
                };const showAlert = (type, msg) => {
                    hideAlert();
                    const markup = `<div class="alerts alerts--${type}">${msg}</div>`;
                    document.querySelector("body").insertAdjacentHTML("afterbegin", markup);
                    window.setTimeout(hideAlert, 4000);
                };
                showAlert("error", "Item Already Added");
                </script>';
        }
    } else {
        $item_array = array(
            'item_id'            =>    $_GET["id"],
            'item_name'            =>    $_POST["hidden_name"],
            'item_image'        =>    $_POST["hidden_pic"],
            'item_price'        =>    $_POST["hidden_price"],
            'item_quantity'        =>    $_POST["quantity"]
        );
        $_SESSION["cart"][0] = $item_array;
        echo '<script>
                const hideAlert = () => {
                    const el = document.querySelector(".alerts");
                    if (el) el.parentElement.removeChild(el);
                };const showAlert = (type, msg) => {
                    hideAlert();
                    const markup = `<div class="alerts alerts--${type}">${msg}</div>`;
                    document.querySelector("body").insertAdjacentHTML("afterbegin", markup);
                    window.setTimeout(hideAlert, 4000);
                };
                showAlert("success", "Item Added");
                </script>';
    }
    header('Location: index.php');
}

if (isset($_GET["action"])) {
    if ($_GET["action"] == "delete") {
        foreach ($_SESSION["cart"] as $keys => $values) {
            if ($values["item_id"] == $_GET["id"]) {
                unset($_SESSION["cart"][$keys]);
                echo '<script>
                const hideAlert = () => {
                    const el = document.querySelector(".alerts");
                    if (el) el.parentElement.removeChild(el);
                };const showAlert = (type, msg) => {
                    hideAlert();
                    const markup = `<div class="alerts alerts--${type}">${msg}</div>`;
                    document.querySelector("body").insertAdjacentHTML("afterbegin", markup);
                    window.setTimeout(hideAlert, 4000);
                };
                showAlert("error", "Item Removed");
                </script>';
            }
        }
    }
}


?>


<?php include('templates/header.php'); ?>
<section class="cart-body">
    <div class="container">
        <div class=" section-title">
            <h1 class="text-center alert alert-success">Cart</h1>

        </div>

        <div class="row">

            <?php
            if (!empty($_SESSION["cart"])) {
                $total = 0;

                foreach ($_SESSION["cart"] as $keys => $values) {
            ?>

                    <div class="col-md-6">
                        <div class="">
                            <div class="cart d-flex align-items">

                                <div class="">
                                    <h3><?php echo $values["item_name"]; ?></h3>
                                    <img class="" src="admin/<?= $values['item_image'] ?>">

                                </div>
                                <div class="cart-info">

                                    <h4>Quantity: <?php echo $values["item_quantity"]; ?>
                                    </h4>
                                    <h4>Unit Price: $<?php echo $values["item_price"]; ?> </h4>
                                    <h5>Price: $<?php echo number_format($values["item_quantity"] * $values["item_price"], 2); ?></h5>
                                    <a href="cart.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="btn btn-danger remove">Remove</span></a>
                                </div>
                            </div>
                        </div>

                    </div>
                    <?php

                    ?>
                <?php
                    $total = $total + ($values["item_quantity"] * $values["item_price"]);
                }
                ?>

        </div>
    </div>

    <h5 class="total py-3">Total: $<?php echo number_format($total, 2); ?></h5>
<?php } ?>
<center><a href="" class="btn btn-primary alert alert-primary"><i class="fas fa-money-check"> Order</i></a></center>
</section>

<?php include('templates/footer.php'); ?>