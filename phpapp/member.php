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
        //echo "method found"; //uncomment to debug for errors in form send

        $sql = "SELECT member.name, artist.logo, member.image, role.name as role
                FROM (member INNER JOIN artist ON member.artistid = artist.artistid)
                INNER JOIN role ON member.roleid = role.roleid
                WHERE member.name = '" . $_GET["submit"] . "';
                    ";
    } else {
        echo "error in method post";    
    }

    //echo "<br>" . $_GET["submit"] . "<br>"; //uncomment to debug what the button is sending
       
    //echo $sql; //uncomment to debug what the result is, using this value in phpmyadmin to debug if there are syntax errors you can't spot

    $result = $link->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        //output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr><td><div class='bg'><p>" . $row["name"]. "</p></div></td><td><img src=" . $row["logo"]. "></td></tr>";
            echo "<tr><td><img src=" . $row["image"]. "></td><td><div class='bg'><p>" . $row["role"]. "</p></div></td></tr>";
            //echo "<tr><td><form action='members.php' method='get'><input type='hidden' name='submit' value='" . $row["name"]. "'><div class='bg'><p>Songs</p></div></form></td><td><div class='bg'><p>" . $row["publishdate"]. "</p></div></td></tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }

    $link->close();
    ?>
    

    </section>
    </div>

    <?php
        include ('footer.html');
    ?>

</body>
</html>