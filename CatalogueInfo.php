<?php

require_once 'DataBaseConnection.php';
$infonum = $_GET['prodID'];
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