<?php

session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name = "";
$name_err = "";

$param_name = "";

##################################

$stmt = mysqli_prepare($link, "DELETE FROM album WHERE name= ?");
mysqli_stmt_bind_param($stmt, 's', $param_name);

$param_name = "";

##############################################


// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate name
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter a name.";
    } else {
        $name = trim($_POST["name"]);
        // Prepare a select statement
        $sql = "SELECT name FROM album WHERE name = '" . $_POST["name"] . "';";
        
        $result = $link->query($sql);

         if ($result->num_rows > 0) {
            $param_name = $name;
         } else {
            $name_err = "This name doesn't exist.";
         }
    }

    //execute prepared statement 
    if (empty($name_err)) {
        if (mysqli_stmt_execute($stmt)) {
            echo "SUCCESSFULLY DELETED ALBUM";
            $name = "";
        } else {
            echo "something went wrong";
        }
    } else {
        echo "something went wrong";
    }
    //printf("%d Row inserted.\n", mysqli_stmt_affected_rows($stmt));

    //close statement and connection
    mysqli_stmt_close($stmt);

    //close connection
    mysqli_close($link);

}
    

?>


<!DOCTYPE html>
<html lang="en">

<?php
    include ('head.html');
?>

<body>

     <?php
        include('navbar.html');
    ?>

    <div class="container" style="margin-top:30px">
    <section class="content container-fluid">

        <div class="wrapper">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                <label>Which album do you want to delete?</label>
                <br />
                <br />
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                <span class="help-block"><?php echo $name_err; ?></span>
            </div>    
            <div class="form-group">
                <input type="submit" class="btn btn-outline-light text-light" value="Submit">
                <input type="reset" class="btn btn-outline-light text-light" value="Reset">
            </div>
        </form>
        </div>    

    </section>
    </div>


   

<?php
    include ('footer.html');
?>

</body>
</html>