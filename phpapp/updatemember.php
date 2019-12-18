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
$role = $artist = $name = $image = $oldname = "";
$role_err = $artist_err = $name_err = $image_err = $oldname_err = "";

$param_role = $param_artist = $param_name = $param_image = "";

##################################



##############################################


// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    $stmt = mysqli_prepare($link, "UPDATE member SET roleid = ?, artistid = ?, name = ?, image = ? WHERE name = '" . $_POST["oldname"] . "'");
    mysqli_stmt_bind_param($stmt, 'iiss', $param_role, $param_artist, $param_name, $param_image);

    $param_role = "";
    $param_artist = "";
    $param_name = "";
    $param_image = "";


    // Validate old name
    if (empty(trim($_POST["oldname"]))) {
        $oldname_err = "Please enter a name.";
    } else {
        $oldname = trim($_POST["oldname"]);
        // Prepare a select statement
        $sql = "SELECT name FROM member WHERE name = '" . $_POST["oldname"] . "';";
        
        $result = $link->query($sql);

         if ($result->num_rows > 0) {
            $param_oldname = $oldname;

            // Validate name
                if (empty(trim($_POST["name"]))) {
                    $name_err = "Please enter a name.";
                } else {
                    $name = trim($_POST["name"]);
                    // Prepare a select statement
                    $sql = "SELECT name FROM member WHERE name = '" . $_POST["name"] . "';";
        
                    $result = $link->query($sql);

                     if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            if ($_POST["name"] === $row["name"] && $_POST["oldname"] === $_POST["name"]) {
                                $param_name = $name;
                            } else {
                                $name_err = "This name is taken.";
                            }
                        }
                     } else {
                        $param_name = $name;
                     }
                }

         } else {
            $oldname_err = "This name doesn't exist.";
         }
    }
    
    

    // Validate role
    if (empty(trim($_POST["role"]))) {
        $role_err = "Please enter a role.";
    } else {
        $role = trim($_POST["role"]);
        // Prepare a select statement
        $sql = "SELECT roleid FROM role WHERE name = '" . $_POST["role"] . "';";
        
        $result = $link->query($sql);

        if ($result->num_rows > 0) {
            
            while($row = $result->fetch_assoc()) {
                $role = $row["roleid"];
            }

            $param_role = $role;
        } else {
            $name_err = "This role doesn't exist.";
        }
    }

    // Validate artist
    if (empty(trim($_POST["artist"]))) {
        $artist_err = "Please enter an artist.";
    } else {
        $artist = trim($_POST["artist"]);
        
        // Prepare a select statement
        $sql = "SELECT artistid FROM artist WHERE name = '" . $_POST["artist"] . "';";
        
        $result = $link->query($sql);

        if ($result->num_rows > 0) {
            
            while($row = $result->fetch_assoc()) {
                $artist = $row["artistid"];
            }

            $param_artist = $artist;
        } else {
            $name_err = "This artist doesn't exist.";
        }
    }

    // Validate image
    if (empty(trim($_POST["image"]))) {
        $image_err = "Please enter an image url.";
    } else {
        $image = trim($_POST["image"]);
        // Prepare a select statement
        $sql = "SELECT image FROM member WHERE image = '" . $_POST["image"] . "';";
        
        $result = $link->query($sql);

        $param_image = $image;
    }


    /* execute prepared statement */

    if(empty($name_err) && empty($role_err) && empty($artist_err) && empty($image_err) && empty($oldname_err)) {

        if (mysqli_stmt_execute($stmt)) {
            echo "SUCCESSFULLY UPDATED MEMBER";
            $role = $artist = $name = $image = $oldname = "";
        } else {
            echo "something went wrong";
        }
    } else {
        echo "something went wrong";
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
            <div class="form-group <?php echo (!empty($oldname_err)) ? 'has-error' : ''; ?>">
                <label>Who do you want to update?</label>
                <input type="text" name="oldname" class="form-control" value="<?php echo $oldname; ?>">
                <span class="help-block"><?php echo $oldname_err; ?></span>
                <br />
                <br />
            </div>
            <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                <label>New name</label>
                <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                <span class="help-block"><?php echo $name_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($role_err)) ? 'has-error' : ''; ?>">
                <label>Role</label>
                <input type="text" name="role" class="form-control" value="<?php echo $role; ?>">
                <span class="help-block"><?php echo $role_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($artist_err)) ? 'has-error' : ''; ?>">
                <label>Artist</label>
                <input type="text" name="artist" class="form-control" value="<?php echo $artist; ?>">
                <span class="help-block"><?php echo $artist_err; ?></span>
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