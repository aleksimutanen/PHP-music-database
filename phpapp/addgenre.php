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
$name = $image = "";
$name_err = $image_err = "";

$param_name = $param_image = "";

##################################

$stmt = mysqli_prepare($link, "INSERT INTO genre (name, image) VALUES (?, ?)");
mysqli_stmt_bind_param($stmt, 'ss', $param_name, $param_image);

$param_name = $param_image = "";

##############################################


// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate name
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter a name.";
    } else {
        $name = trim($_POST["name"]);
        // Prepare a select statement
        $sql = "SELECT name FROM artist WHERE name = '" . $_POST["name"] . "';";
        
        $result = $link->query($sql);

         if ($result->num_rows > 0) {
            $name_err = "This name is already taken.";
         } else {
            $param_name = $name;
         }
    }

    // Validate image
    if (empty(trim($_POST["image"]))) {
        $image_err = "Please enter an image url.";
    } else {
        $image = trim($_POST["image"]);
        // Prepare a select statement
        $sql = "SELECT image FROM genre WHERE image = '" . $_POST["image"] . "';";
        
        $result = $link->query($sql);

        if ($result->num_rows > 0) {
            
            $image_err = "This image is already used.";

        } else {
            $param_image = $image;
        }
    }

    /* execute prepared statement */

    if(empty($name_err) && empty($image_err)) {

        if (mysqli_stmt_execute($stmt)) {
            echo "SUCCESSFULLY ADDED GENRE";
            $name = "";
            $image = "";
        } else {
            echo "something went wrong";
        }
    } else {
        echo "something went wrong";
        $name = $_POST["name"];
        $image = $_POST["image"];
    }

    //printf("%d Row inserted.\n", mysqli_stmt_affected_rows($stmt));

    /* close statement and connection */
    mysqli_stmt_close($stmt);

    /* close connection */
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
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                <span class="help-block"><?php echo $name_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($image_err)) ? 'has-error' : ''; ?>">
                <label>Image URL</label>
                <input type="text" name="image" class="form-control" value="<?php echo $image; ?>">
                <span class="help-block"><?php echo $image_err; ?></span>
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