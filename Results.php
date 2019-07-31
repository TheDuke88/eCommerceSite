<?php
session_start();
unset($_SESSION['badPass']);

$Fname = $_POST['Fname'];
$Lname = $_POST['Lname'];
$Email = $_POST['Email'];
$Password = $_POST['Password'];

require_once 'DataBaseConnection.php';
?>
<html>      
    <head>
        <meta charset="UTF-8">
        <title>Results</title>
        <meta name="viewport"
              content="width=device-width, initial-scale=1">      
    </head>
    <body>

        <?php
        $Hashed = hash("ripemd128", $Password);
        $search = "SELECT * FROM Library.UserInfo WHERE Email='" . $Email . "'";
        $return = $con->query($search);
        $count = $return->num_rows;
        
        if ($count >= 1) {
            
            echo '<script type="text/javascript">';
            echo 'alert("You already have an account. Please login!");';
            echo 'location="LogInForm.php";';
            echo '</script>';
            echo $search;
            
        } else {

            $insert = "INSERT INTO `Library`.`UserInfo`(`Fname`, `Lname`, `Email`, `Password`, `Active`) VALUES ('$Fname','$Lname','$Email', '$Hashed','Y')";
            $success = $con->query($insert);

            if ($success == FALSE) {
                $failmess = "Whole query " . $insert . "<br>";
                echo $failmess;
                die('invalid query: ' . mysqli_error($con));
            } else {
                echo "An account was made for,  ";
                echo "$Fname $Lname<br>";
                $_SESSION['user'] = $Email;
                $_SESSION['password'] = $Password;
            }
        }

        $con->close;
        ?>
        <a href="Catalogue.php">Click to start shopping <a>

    </body>
</html>
