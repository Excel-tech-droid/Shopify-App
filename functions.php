<?php
function selectProduct($category)
{
    global $categorys;
    include('config/db_connect.php');
    // write query for all products
    $sql = "SELECT * FROM products WHERE category = '$category'";
    // make query and get result

    $result = mysqli_query($conn, $sql);
    // fetch the resulting rows as an array 
    $categorys = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // free result from memory
    mysqli_free_result($result);
}
