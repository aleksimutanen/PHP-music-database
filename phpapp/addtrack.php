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
$album = $name = $length = $artist = "";
$album_err = $name_err = $length_err = $artist_err = "";

$param_album = $param_name = $param_length =  $param_artist = "";

##################################

$stmt = mysqli_prepare($link, "INSERT INTO track (albumid, name, length, artistid) VALUES (?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, 'issi', $param_album, $param_name, $param_length, $param_artist);

$param_album = $param_name = $param_length = $param_artist = "";

##############################################


// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
     
    // Validate album
    if (empty(trim($_POST["album"]))) {
        $album_err = "Please enter an album name.";
    } else {
        $album = trim($_POST["album"]);
        // Prepare a select statement
        $sql = "SELECT albumid FROM album WHERE name = '" . $_POST["album"] . "';";
        $artistsql = "SELECT artist.artistid, album.name
                        FROM album
                        INNER JOIN artist ON artist.artistid = album.artistid 
                        WHERE album.name = '" . $_POST["album"] . "';";

        $result = $link->query($artistsql);
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $artist = $row["artistid"];
                $param_artist = $artist;   
            }
        }

        $result = $link->query($sql);

         if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $album = $row["albumid"];
            }

            $param_album = $album;
         } else {
            $album_err = "This album doesn't exist.";
         }
    }

    // Validate name
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter a track name.";
    } else {
        $name = trim($_POST["name"]);
        // Prepare a select statement
        $sql = "SELECT name FROM track WHERE name = '" . $_POST["name"] . "';";
        
        $result = $link->query($sql);

         if ($result->num_rows > 0) {
            $name_err = "This name is already taken.";
         } else {
            $param_name = $name;
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

    /* execute prepared statement */

    if(empty($name_err) && empty($albumn_err) && empty($length_err) && empty($artist_err)) {

        if (mysqli_stmt_execute($stmt)) {
            echo "SUCCESSFULLY ADDED TRACK";
            $album = $name = $length = $artist = "";
        } else {
            echo "something went wrong";
        }
    } else {
        echo "something went wrong";
        $name = $_POST["name"];
        $album = $_POST["album"];
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
            <div class="form-group <?php echo (!empty($album_err)) ? 'has-error' : ''; ?>">
                <label>Album name</label>
                <input type="text" name="album" class="form-control" value="<?php echo $album; ?>">
                <span class="help-block"><?php echo $album_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                <label>Track name</label>
                <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                <span class="help-block"><?php echo $name_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($length_err)) ? 'has-error' : ''; ?>">
                <label>Length</label>
                <input type="text" name="length" class="form-control" value="<?php echo $length; ?>" placeholder="hh:mm:ss">
                <span class="help-block"><?php echo $length_err; ?></span>
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