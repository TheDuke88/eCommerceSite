<?php
session_start();
setlocale(LC_MONETARY, 'en_US');
$product_id = $_POST['Select_Product'];  //the product id from dropdown 
$action = $_POST['action']; //the action from the URL
switch ($action) { //decide what to do
    case "Add":
        //echo "Adding";
        $_SESSION['cart'][$product_id] ++; //add one to the quantity of the product with id $product_id 
        break;
    case "Remove":
        //echo "removing";
        $_SESSION['cart'][$product_id] --; //remove one from the quantity of the product with id $product_id 
        if ($_SESSION['cart'][$product_id] <= 0)
            unset($_SESSION['cart'][$product_id]); //if the quantity is zero, remove it completely (using the 'unset' function) - otherwise is will show zero, then -1, -2 etc when the user keeps removing items. 
        break;
    case "Empty":
        unset($_SESSION['cart']); //unset the whole cart, i.e. empty the cart. 
        break;
    case "Info":
        $infonum = $product_id;
        break;
    case "Log Out";
         unset($_SESSION['user']);
         unset($_SESSION['password']);
         unset($_SESSION['cart']);
         session_destroy();
         header("Location:LogInForm.php");
         break;
       
}
//print_r($_SESSION);
require_once 'DataBaseConnection.php';
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Catalogue</title>
        <script type="text/javascript" src="view.js"></script>
        <script>
            function productInfo(key) {
                //creates the datafile with query string
                var data_file = "CatalogueInfo.php?prodID=" + key;
                //this is making the http request
                var http_request = new XMLHttpRequest();
                try {
                    // Opera 8.0+, Firefox, Chrome, Safari
                    http_request = new XMLHttpRequest();
                } catch (e) {
                    // Internet Explorer Browsers
                    try {
                        http_request = new ActiveXObject("Msxml2.XMLHTTP");
                    } catch (e) {
                        try {
                            http_request = new ActiveXObject("Microsoft.XMLHTTP");
                        } catch (e) {
                            // Something went wrong
                            alert("Your browser broke!");
                            return false;
                        }
                    }
                }
                http_request.onreadystatechange = function () {
                    if (http_request.readyState == 4)
                    {
                        var text = http_request.responseText;

                        //this is adding the elements to the HTML in the page
                        document.getElementById("productInformation").innerHTML = text;
                    }
                }
                http_request.open("GET", data_file, true);
                http_request.send();
            }
        </script>

        <link href="/CSIS2440/CodeEx/view.css" rel="stylesheet" type="text/css">
        
    </head>
    <body>
        <div class="form" id="form_container">
            <form action="Catalogue.php" method="Post">
                <div >

                    <p><span class="text">Please Select a product:</span>
                        <select id="Select_Product" name="Select_Product" onchange="productInfo(this.value)" class="select">
                            <option value=""></option>
                            <?php
                            //setting the select statement and running it
                            $search = "SELECT * FROM Library.Products order by Name";
                            $return = $con->query($search);

                            if (!$return) {
                                $message = "Whole query " . $search;
                                echo $message;
                                die('Invalid query: ' . mysqli_error());
                            }
                            while ($row = mysqli_fetch_array($return)) {
                                if ($row['ProductID'] == $product_id) {
                                    echo "<option value='" . $row['ProductID']
                                    . "' selected='selected'>"
                                    . $row['Name'] . "</option>";
                                } else {
                                    echo "<option value='" . $row['ProductID'] . "'>"
                                    . $row['Name'] . "</option>";
                                }
                            }
                            ?>
                        </select></p>
                    <table>
                        <tr>
                            <td>
                                <input id="button_Add" type="submit" value="Add" name="action" class="button"/>
                            </td>
                            <td>
                                <input name="action" type="submit" class="button" id="button_Remove" value="Remove"/>
                            </td>
                            <td>
                                <input name="action" type="submit" class="button" id="button_empty" value="Empty"/>
                            </td>
                            <td>
                                <input name="action" type="submit" class="button" id="button_Info" value="Info"/>
                            </td>
                        </tr>                    
                    </table>

                </div>
                <div id="productInformation">

                </div>
                <div>
                    <?php
                    if ($infonum > 0) {
                        $sql = "SELECT Name, Description, Price, ItemImage FROM Library.Products WHERE ProductID = " . $infonum;
                        //echo $sql;
                        echo "<table align ='left' width='100%'><tr><th>Name</th><th>Description</th><th>Price</th></tr>";
                        $result = $con->query($sql);
                        //Only display the row if there is a product (though there should always be as we have already checked)
                        if (mysqli_num_rows($result) > 0) {
                            list($infoname, $infodescription, $infoprice, $infoimage) = mysqli_fetch_row($result);

                            echo "<tr>";
                            //show this information in table cells
                            echo "<td align=\"center\" width=\"450px\">$infoname</td>";
                            echo "<td align=\"left\">$infodescription</td>";
                            echo "<td align=\"center\" width=\"325p\">" . money_format('%(#8n', $infoprice) . " </td>";
                            echo "<td align=\"left\" width=\"450px\"><img src='images\\$infoimage' height=\"160\" width=\"160\"></td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                    }
                    ?>
                </div>
                <div>
                    <?php
                    if ($_SESSION['cart']) { //if the cart isn't empty
                        //show the cart
                        echo "<table border=\"1\" padding=\"3\" width=\"640px\"><tr><th>Name</th><th>Quantity</th><th width=\"80px\">Price Per Unit</th>"
                        . "<th width=\"80px\">Total Cost for Units</th></tr>"; //format the cart using a HTML table
                        //iterate through the cart, the $product_id is the key and $quantity is the value
                        foreach ($_SESSION['cart'] as $product_id => $quantity) {
                            $sql = "SELECT Name, Price FROM Library.Products WHERE ProductID = " . $product_id;
                            //echo $sql; 
                            $result = $con->query($sql);
                            //Only display the row if there is a product (though there should always be as we have already checked)
                            if (mysqli_num_rows($result) > 0) {
                                list($name, $price) = mysqli_fetch_row($result);
                                $line_cost = $price * $quantity;  //work out the line cost
                                $total = $total + $line_cost; //add to the total cost
                                echo "<tr>";
                                //show this information in table cells
                                echo "<td align=\"Left\" width=\"450px\">$name</td>";
                                echo "<td align=\"center\" width=\"75px\">$quantity</td>";
                                echo "<td align=\"center\" width=\"75px\">" . money_format('%(#8n', $price) . "</td>";
                                echo "<td align=\"center\">" . money_format('%(#8n', $line_cost) . "</td>";
                                echo "</tr>";
                            }
                        }
                        //show the total
                        echo "<tr>";
                        echo "<td align=\"right\"></td><td align=\"right\"></td><td align=\"right\">Order Total</td>";
                        echo "<td align=\"right\">" . money_format('%(#8n', $total) . "</td>";
                        echo "</tr>";
                        echo "</table>";
                        
                    } else {
                        //otherwise tell the user they have no items in their cart
                        echo "You have no items in your shopping cart.";
                    }
                   
                    mysqli_close($conndb)
                    ?>

                </div>
                <p>Unsets user, password, cart, and destroys session. Added after I submitted the zip file. </p>
                <input name="action" type="submit" class="button" id="button_Info" value="Log Out"/>
            </form>
             
            
        </div>
    </body>
</html>