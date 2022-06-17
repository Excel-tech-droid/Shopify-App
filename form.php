<?php

// sessions
if (isset($_POST['submit'])) { 
    //cookie for gender
    setcookie('gender', $_POST['gender'], time() + 86400);

    session_start();

    $_SESSION['name'] = $_POST['name'];

    header('Location: index.php');
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <form class="form-group" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
        <h2>
            <center>Login Form</center>
        </h2>
        <div class="form-group">
            <label for="name">Name: </label>
            <input class="form-control" type="text" name="name" id="name"><br>
            <label for="gender">Gender: </label>
            <input class="form-control" list="gender" name="gender">
            <datalist  id="gender">
                <option value="Male"></option>
                <option value="Female"></option>
            </datalist><br>

            <input class="btn btn-success" type="submit" name="submit" value="submit">
        </div>

    </form>

</body>

</html>