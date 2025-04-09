<?php
// Server Settings
$db_server = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "moderntech";
$port = 3306;
$conn = "";

// Error Handling:
try{
    $conn = mysqli_connect($db_server, $db_username, $db_password, $db_name, $port);
} catch (mysqli_sql_exception){
    echo "Database is not connected <br>";
}
