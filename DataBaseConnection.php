<?php

$host = "localhost";
$user = "root";
$password = "DBAdmin";
$dbname = "Library";
$con = new mysqli($host, $user, $password, $dbname)
        or die('Could not connect to the database server. ' . mysqli_connect_error($con));

//echo "<h2>we connected<h2>";

function mysql_fix_string($conn, $string) {
    if (get_magic_quotes_gpc()) {
        $string = stripslashes($string);
    }
    $string = htmlentities($string);
    return $conn->real_escape_string($string);
}
?>