<?php

session_start();
$db_host = 'localhost';
$db_user = 'root';
$db_pass = 'excel123';
$db_name = 'shopify';
 
$con = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if ( mysqli_connect_errno()) {
    exit('failed to connect to mysql: ' . mysqli_connect_error());
}
// checking if form i submitted
if ( !isset($_POST['username'], $_POST['password']) ) {
    exit ('Please fill both username and password fields!');
}


//preventing sql injection
if ($stmt = $con->prepare('SELECT id, password FROM admin where username = ? ')) {
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    $stmt->store_result();
     
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password);
        $stmt->fetch();

        if ($_POST['password'] === $password) {

            session_regenerate_id();
            $_SESSION['adminloggedin'] = TRUE;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['id'] = $id;
            header('Location: adminpage.php') ;
        } else{
            echo 'Incorrect username and/or password!';
        }
    } else{
        echo 'Incorrect username and/or password!';
    }



    $stmt->close();
}

 mysqli_close($con);

?>