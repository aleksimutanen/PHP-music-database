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
$genre = $logo = $name = $image = $oldname = $info = $country = "";
$genre_err = $logo_err = $name_err = $image_err = $oldname_err = $info_err = $country_err = "";

$param_genre = $param_logo = $param_name = $param_image = $param_info = $param_country = "";

##################################



##############################################


// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    $stmt = mysqli_prepare($link, "UPDATE artist SET genreid = ?, logo = ?, name = ?, image = ?, info = ?, country = ? WHERE name = '" . $_POST["oldname"] . "'");
    mysqli_stmt_bind_param($stmt, 'isssss', $param_genre, $param_logo, $param_name, $param_image, $param_info, $param_country);

    $param_genre = "";
    $param_logo = "";
    $param_name = "";
    $param_image = "";
    $param_info = "";
    $param_country = "";

    // Validate old name
    if (empty(trim($_POST["oldname"]))) {
        $oldname_err = "Please enter a name.";
    } else {
        $oldname = trim($_POST["oldname"]);
        // Prepare a select statement
        $sql = "SELECT name FROM artist WHERE name = '" . $_POST["oldname"] . "';";
        
        $result = $link->query($sql);

         if ($result->num_rows > 0) {
            $param_oldname = $oldname;

            // Validate name
                if (empty(trim($_POST["name"]))) {
                    $name_err = "Please enter a name.";
                } else {
                    $name = trim($_POST["name"]);
                    // Prepare a select statement
                    $sql = "SELECT name FROM artist WHERE name = '" . $_POST["name"] . "';";
        
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
    if (empty(trim($_POST["logo"]))) {
        $logo_err = "Please enter a logo url.";
    } else {
        $logo = trim($_POST["logo"]);
        // Prepare a select statement
        $sql = "SELECT logo FROM artist WHERE name = '" . $_POST["logo"] . "';";
        
        $result = $link->query($sql);

        $param_logo = $logo;
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

     // Validate info
    if (empty(trim($_POST["info"]))) {
        $info_err = "Please enter info.";
    } else {
        $info = trim($_POST["info"]);
        // Prepare a select statement
        $sql = "SELECT info FROM artist WHERE info = '" . $_POST["info"] . "';";
        
        $result = $link->query($sql);

        $param_info = $info;
    }

     // Validate country
    if (empty(trim($_POST["country"]))) {
        $country_err = "Please enter country.";
    } else {
        $country = trim($_POST["country"]);
        // Prepare a select statement
        $sql = "SELECT country FROM artist WHERE country = '" . $_POST["country"] . "';";
        
        $result = $link->query($sql);

        $param_country = $country;
    }


    /* execute prepared statement */

    if(empty($name_err) && empty($genre_err) && empty($logo_err) && empty($image_err) && empty($oldname_err) && empty($info_err) && empty($country_err)) {

        if (mysqli_stmt_execute($stmt)) {
            echo "SUCCESSFULLY UPDATED ARTIST";
            $genre = $logo = $name = $image = $oldname = $info = $country = "";
        } else {
            echo "something went wrong";
        }
    } else {
        echo "something went wrong";
        $genre = $_POST["genre"];

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
                <label>Which artist do you want to update?</label>
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
            <div class="form-group <?php echo (!empty($genre_err)) ? 'has-error' : ''; ?>">
                <label>Genre</label>
                <input type="text" name="genre" class="form-control" value="<?php echo $genre; ?>">
                <span class="help-block"><?php echo $genre_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($logo_err)) ? 'has-error' : ''; ?>">
                <label>Logo</label>
                <input type="text" name="logo" class="form-control" value="<?php echo $logo; ?>">
                <span class="help-block"><?php echo $logo_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($image_err)) ? 'has-error' : ''; ?>">
                <label>Image URL</label>
                <input type="text" name="image" class="form-control" value="<?php echo $image; ?>">
                <span class="help-block"><?php echo $image_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($info_err)) ? 'has-error' : ''; ?>">
                <label>Describe the artist</label>
                <input type="text" name="info" class="form-control" value="<?php echo $info; ?>">
                <span class="help-block"><?php echo $info_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($country_err)) ? 'has-error' : ''; ?>">
                <label>Country abbreviation</label>
                <input type="text" name="country" class="form-control" value="<?php echo $country; ?>" placeholder="max 3 letter abbreviation, USA / CN etc.">
                <span class="help-block"><?php echo $country_err; ?></span>
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