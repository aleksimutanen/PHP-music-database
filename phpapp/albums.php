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

        $sql = "SELECT album.name, album.image, artist.name as artist
                FROM album
                INNER JOIN artist ON album.artistid = artist.artistid
                ORDER BY album.name;
                    ";

        $result = $link->query($sql);

        if ($result->num_rows > 0) {
            echo "<table>";
            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr><td><form action='album.php' method='get'><input id='select-album' type='submit' name='submit' value='" . $row["name"]. "'></form></td><td><img src=" . $row["image"]. "></td><td><form action='artist.php' method='get'><input id='select-artist' type='submit' name='submit' value='" . $row["artist"]. "'></form></td></tr>";
            }
            echo "</table>";
        } else {
            echo "0 results";
        }

        $link->close();
    ?>
    
    <table>
        <tr>
            <td><a href="addalbum.php" class="btn btn-outline-light text-light" role="button">Add album</a></td>
            <td><a href="updatealbum.php" class="btn btn-outline-light text-light" role="button">Update album</a></td>
            <td><a href="deletealbum.php" class="btn btn-outline-light text-light" role="button">Delete album</a></td>
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