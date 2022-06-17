           <!--------for the search bar---------->
           <div class="container-fluid">
               <div class="row">

                   <div class="input-group">

                       <input class="form-control" type="text" id="search" style="display:inline;">
                       <label class="input-group-text" for="search"><a href="#"><i class="fas fa-search"></i></a></label>
                   </div>


               </div>
           </div>




           <?php
            set_time_limit(20);
            while ($i <= 10) {
                echo "i = $i";
                sleep(100);
                $i++;
            }
            ?>

            <!-- <?php
session_start();
include('header.php');
if (isset($_GET['id_to_delete'])) {
    $id_to_delete = mysqli_real_escape_string($conn, $_GET['id_to_delete']);
    // write query for all members
    $sql = "SELECT * FROM members WHERE id = $id_to_delete";
    // make query and get result
    $result = mysqli_query($conn, $sql);
    // fetch the resulting rows as an array 
    $member = mysqli_fetch_assoc($result);
    // free result from memory
    mysqli_free_result($result);

    if (isset($_POST['yes'])) {
        $id_to_delete = $_POST['id_to_delete'];

        $sql = "DELETE FROM members WHERE id = $id_to_delete";

        if (mysqli_query($conn, $sql)) {
            // success
            header('Location: members.php');
        } else {
            // failure
            echo 'query error: ' . mysqli_error($conn);
        }
    }
}
?>

<?php if (isset($_GET['id_to_delete'])) { ?>
    <div class="container pt-5">
        <h3 class="text-warning">Are you sure you want to delete <span class="text-dark"> <?php echo $member['firstname']; ?></span> </h3>
        <h4 class="text-capitalize"> </h4>
        <form class="mt-5" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <input type="hidden" name="id_to_delete" value="<?php echo $_GET['id_to_delete']; ?>">
            <a href="members.php" class="btn btn-danger"><i class="fas fa-times-circle"></i> No</a>
            <button type="submit" name="yes" class="btn btn-success yes" value="yes"><i class="fas fa-check-circle">Yes</i></button>
        </form>
    </div>

<?php } ?> -->