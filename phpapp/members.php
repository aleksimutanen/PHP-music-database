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

        $sql = "SELECT member.name, role.name as role, artist.name as artist
                FROM (member INNER JOIN artist ON member.artistid = artist.artistid)
                INNER JOIN role ON member.roleid = role.roleid
                WHERE artist.name = '" . $_GET["submit"] . "'
                ORDER BY name;
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
                echo "<tr><td><form action='member.php' method='get'><input id='select-member' type='submit' name='submit' value='" . $row["name"]. "'></form></td><td>" . $row["role"]. "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "0 results";
        }

        $link->close();
    ?>
    <table>
        <tr>
            <td><a href="addmember.php" class="btn btn-outline-light text-light" role="button">Add member</a></td>
            <td><a href="updatemember.php" class="btn btn-outline-light text-light" role="button">Update member</a></td>
            <td><a href="deletemember.php" class="btn btn-outline-light text-light" role="button">Delete member</a></td>
        </tr>
    </table>
    

    </section>
    </div>

    <?php
        include ('footer.html');
    ?>

</body>
</html>