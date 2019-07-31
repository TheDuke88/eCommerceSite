<?php
session_start();
unset($_SESSION['badPass']);
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        
        <title>Create an Account</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src = "myjs.js" type="text/javascript">
        </script>  
        
    </head>
    <body>
        
        <h2>Create an Account</h2>
        <form name="myForm" method="post" role="form" action = "Results.php">
            <ul>
                <li> 
                    <label for = "Fname">First Name:</label>
                    <input id = "Fname" name='Fname' type="text" class = "form-control">
                </li>
                <li>
                    <label for = "Lname">Last Name:</label>
                    <input  id = "Lname" name='Lname' type="text" class = "form-control">
                </li>
                <li>
                    <label for = "Email">Email:</label>
                    <input id = "Email" name='Email' type="text" class = "form-control">
                </li>
                <li>
                    <label for = "Password">Password:</label>
                    <input name='Password' type="Password" class = "form-control">
                </li>
                <li>    
                    <input type="submit" value="Create Account" onclick = "return(validate());" class = "btn btn-default">
                </li>
            </ul>
        </form>
        
        <a href="LogInForm.php">Login Page</a>

        <h5>Fill out form and press Create a new account.</h5>

        <div id="errorlog">
        </div>

    </body>
</html>
