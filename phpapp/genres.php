<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
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

    <?php
    require_once "config.php";

        $sql = "SELECT name, image
                FROM genre
                ORDER BY name;
                    ";

        $result = $link->query($sql);

        if ($result->num_rows > 0) {
            echo "<table>";
            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr><td><form action='genre.php' method='get'><input id='select-genre' type='submit' name='submit' value='" . $row["name"]. "'></form></td><td><img src=" . $row["image"]. "></td></tr>";
            }
            echo "</table>";
        } else {
            echo "0 results";
        }

        $link->close();
    ?>
    
    <table>
        <tr>
            <td><a href="addgenre.php" class="btn btn-outline-light text-light" role="button">Add genre</a></td>
            <td><a href="deletegenre.php" class="btn btn-outline-light text-light" role="button">Delete genre</a></td>
        </tr>
    </table>

    </section>
    </div>

    <?php
        include ('footer.html');
    ?>

</body>
</html><?php

?>