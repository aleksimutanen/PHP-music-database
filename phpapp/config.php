/*
<?php

    //Database credentials. Assuming you are running MySQL
    //server with default setting (user 'root' with no password)

    define('DB_SERVER', '127.0.0.1');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'localdb');
    
    //Attempt to connect to MySQL database
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
    // Check connection
    if($link === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
        connectionFailed();
    }

    function connectionFailed() {
        echo "Connection failed";
    }

?>
*/


<?php
$connectstr_dbhost = '';
$connectstr_dbname = '';
$connectstr_dbusername = '';
$connectstr_dbpassword = '';

foreach ($_SERVER as $key => $value) {
    if (strpos($key, "MYSQLCONNSTR_localdb") !== 0) {
        continue;
    }
    
    $connectstr_dbhost = preg_replace("/^.*Data Source=(.+?);.*$/", "\\1", $value);
    $connectstr_dbname = preg_replace("/^.*Database=(.+?);.*$/", "\\1", $value);
    $connectstr_dbusername = preg_replace("/^.*User Id=(.+?);.*$/", "\\1", $value);
    $connectstr_dbpassword = preg_replace("/^.*Password=(.+?)$/", "\\1", $value);
}

$connectstr_dbhost = '127.0.0.1:53666';
$connectstr_dbname = 'localdb';
$connectstr_dbusername = 'azure';
$connectstr_dbpassword = '6#vWHD_$';

echo "dbhost: ".$connectstr_dbhost."<br>";
echo "dbname: ".$connectstr_dbname."<br>";
echo "dbusername: ".$connectstr_dbusername."<br>";
echo "dbpassword: ".$connectstr_dbpassword."<br>";


$link = mysqli_connect($connectstr_dbhost, $connectstr_dbusername, $connectstr_dbpassword,$connectstr_dbname);

if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    connectionFailed();
    exit;
}

function connectionFailed() {
        echo "Connection failed";
}


echo "Success: A proper connection to MySQL was made! The my_db database is great." . PHP_EOL;
echo "Host information: " . mysqli_get_host_info($link) . PHP_EOL;


// mysqli_close($link);
?>
