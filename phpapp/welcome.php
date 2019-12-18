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

        <div class="wrapper">
            <div class="page-header">
                <h2>Hello, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to the music database. <a href="logout.php" class="btn btn-danger" style="background-color: black;">Sign Out</a></h2>
            </div>
        </div>    

    </section>
    </div>

    <?php
        include ('footer.html');
    ?>

</body>
</html>