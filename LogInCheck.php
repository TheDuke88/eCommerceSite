<?php
session_start();
unset($_SESSION['badPass']);
// isername and password sent from form 
$myusername = $_POST['myusername'];
$mypassword = $_POST['mypassword'];
//connect to server and select database
require_once 'DataBaseConnection.php';

$myusername = mysql_fix_string($con, $myusername);
$mypassword = mysql_fix_string($con, $mypassword);

$Hashed = hash("ripemd128", $mypassword);
$sql = "SELECT * FROM Library.UserInfo WHERE Email='" . $myusername . "' and Password = '" . $Hashed . "'";
$result = $con->query($sql);

if (!$result) {
    $message = "Whole Query " . $sql;
    echo $message;
    die('Invalid query: ' . mysqli_error());
}
//mysql_num_row is counting table row
$count = $result->num_rows;
//if reslut matched $myusername and $mypassword, table row must be 1 row
if ($count == 1) {
    $_SESSION['user'] = $myusername;
    $_SESSION['password'] = $mypassword;
    //register myusername, password and redirect to file login success
    header("Location:Catalogue.php");
} else {
    echo '<script type="text/javascript">';
    echo 'alert("Not a valid account, you need to create an account!");';
    echo 'location="CreateAccount.php";';
    echo '</script>';
    $_SESSION['badPass'] ++;
}
?>