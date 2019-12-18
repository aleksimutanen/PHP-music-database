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
$genre = $artist = $name = $image = $publishdate = $length = $oldname = "";
$genre_err = $artist_err = $name_err = $image_err = $publishdate_err = $length_err = $oldname_err = "";

$param_genre = $param_artist = $param_name = $param_image = $param_publishdate = $param_length = "";

##################################



##############################################


// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    $stmt = mysqli_prepare($link, "UPDATE album SET genreid = ?, artistid = ?, name = ?, image = ?, publishdate = ?, length = ? WHERE name = '" . $_POST["oldname"] . "'");
    mysqli_stmt_bind_param($stmt, 'iissss', $param_genre, $param_artist, $param_name, $param_image, $param_publishdate, $param_length);

    $param_genre = "";
    $param_artist = "";
    $param_name = "";
    $param_image = "";
    $param_publishdate = "";
    $param_length = "";


    // Validate old name
    if (empty(trim($_POST["oldname"]))) {
        $oldname_err = "Please enter a name.";
    } else {
        $oldname = trim($_POST["oldname"]);
        // Prepare a select statement
        $sql = "SELECT name FROM album WHERE name = '" . $_POST["oldname"] . "';";
        
        $result = $link->query($sql);

         if ($result->num_rows > 0) {
            $param_oldname = $oldname;

            // Validate name
                if (empty(trim($_POST["name"]))) {
                    $name_err = "Please enter a name.";
                } else {
                    $name = trim($_POST["name"]);
                    // Prepare a select statement
                    $sql = "SELECT name FROM album WHERE name = '" . $_POST["name"] . "';";
        
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
            $oldname_err = "This artist doesn't exist.";
         }
    }
    
    

     // Validate genre
    if (empty(trim($_POST["genre"]))) {
        $genre_err = "Please enter a genre.";
    } else {
        $genre = trim($_POST["genre"]);
        // Prepare a select statement
        $sql = "SELECT genreid FROM genre WHERE name = '" . $_POST["genre"] . "';";
        
        $result = $link->query($sql);

        if ($result->num_rows > 0) {
            
            while($row = $result->fetch_assoc()) {
                $genre = $row["genreid"];
            }

            $param_genre = $genre;
        } else {
            $genre_err = "This genre doesn't exist.";
        }
    }

    // Validate artist
    if (empty(trim($_POST["artist"]))) {
        $artist_err = "Please enter a name.";
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
            $artist_err = "This artist doesn't exist.";
         }
    }

    if (empty(trim($_POST["image"]))) {
        $image_err = "Please enter an image url.";
    } else {
        $image = trim($_POST["image"]);
        // Prepare a select statement
        $sql = "SELECT image FROM album WHERE image = '" . $_POST["image"] . "';";
        
        $result = $link->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                if ($_POST["image"] == $row["image"]) {
                    $param_image = $image;
                } else {
                    $image_err = "This image is already used.";
                }
            }
        }
    }

    // Validate length

    if (empty(trim($_POST["length"]))) {
        $length_err = "Please enter the length.";
    } else {
        //$length = trim($_POST["length"]);
        // Prepare a select statement

        //echo $_POST["length"];
            
            $length_err = "";

            $length = $_POST["length"];

            $param_length = $length;
    }

    // Validate publishdate

    if (empty(trim($_POST["publishdate"]))) {
        $publishdate_err = "Please enter a publishdate.";
    } else {
        //$publishdate = trim($_POST["publishdate"]);
        // Prepare a select statement

        //echo $_POST["publishdate"];
            
            $publishdate_err = "";

            $publishdate = $_POST["publishdate"];

            $param_publishdate = $publishdate;
    }

    /* execute prepared statement */

    if(empty($name_err) && empty($genre_err) && empty($artist_err) && empty($image_err) && empty($publishdate_err) && empty($length_err) && empty($oldname_err)) {

        if (mysqli_stmt_execute($stmt)) {
            echo "SUCCESSFULLY UPDATED ALBUM";
            $genre = $artist = $name = $image = $publishdate = $length = $oldname = "";
        } else {
            echo "something went wrong";
        }
    } else {
        echo "something went wrong";
        $name = $_POST["name"];
        $genre = $_POST["genre"];
        $artist = $_POST["artist"];
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
                <label>Which album do you want to update?</label>
                <input type="text" name="oldname" class="form-control" value="<?php echo $oldname; ?>">
                <span class="help-block"><?php echo $oldname_err; ?></span>
                <br />
                <br />
            </div>
            <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                <span class="help-block"><?php echo $name_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($genre_err)) ? 'has-error' : ''; ?>">
                <label>Genre</label>
                <input type="text" name="genre" class="form-control" value="<?php echo $genre; ?>">
                <span class="help-block"><?php echo $genre_err; ?></span>
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
            <div class="form-group <?php echo (!empty($length_err)) ? 'has-error' : ''; ?>">
                <label>Length</label>
                <input type="text" name="length" class="form-control" value="<?php echo $length; ?>" placeholder="hh:mm:ss">
                <span class="help-block"><?php echo $length_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($publishdate_err)) ? 'has-error' : ''; ?>">
                <label>Publishdate</label>
                <input type="text" name="publishdate" class="form-control" value="<?php echo $publishdate; ?>" placeholder="yyyy-mm-dd">
                <span class="help-block"><?php echo $publishdate_err; ?></span>
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