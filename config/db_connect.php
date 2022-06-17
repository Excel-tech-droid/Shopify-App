<?php
// connect to database
$conn = mysqli_connect('localhost', 'dara', 'test1234', 'shopify');

if (!$conn) {
    echo 'connection error' . mysqli_connect_error();
}
