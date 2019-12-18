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

    
    if($_SERVER["REQUEST_METHOD"] == "GET"){
        //echo "method found"; debug for errors in form send

        $sql = "SELECT album.name as album, track.name as trackname, track.length
                FROM track
                INNER JOIN album ON track.albumid = album.albumid
                WHERE album.name = '" . $_GET["submit"] . "'
                ORDER BY trackname;
                    ";

    } else {
        echo "error in method post";    
    }

    //echo "<br>" . $_POST["submit"] . "<br>"; //debugging what the button is sending
       
    //echo $sql; //debugging what the result is, using this value in phpmyadmin to debug if there are syntax errors you can't spot
        $result = $link->query($sql);

        if ($result->num_rows > 0) {
            echo "<table>";
            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["album"]. "</td><td>" . $row["trackname"]. "</td><td>" . $row["length"]. "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "0 results";
        }

        $link->close();
    ?>

        <table>
            <tr>
                <td><a href="addtrack.php" class="btn btn-outline-light text-light" role="button">Add track</a></td>
                <td><a href="deletetrack.php" class="btn btn-outline-light text-light" role="button">Delete track</a></td>
            </tr>
        </table>
    

    </section>
    </div>

    <?php
        include ('footer.html');
    ?>

</body>
</html>