#!/usr/bin/php
<?php
$servername = "localhost";
$username = "homestead";
$password = "secret";
$dbname = "radius";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, username, password, radwinserial, radwinservicecategory, radwinname, radwinlocation, radwinvlan, radwinregisteravailability  FROM radwins";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
       echo "#" . $row["id"] . " \n" . $row["username"] . " Cleartext-Password := \"" . $row["password"] . "\", RADWIN_SerialNumber == \"" . $row["radwinserial"] . "\" \n";
       echo "   RADWIN_ServiceCategory = " . $row["radwinservicecategory"] . " , \n";
       echo "   RADWIN_Name = \"" . $row["radwinname"] . "\", \n";
       echo "   RADWIN_Location = \"" . $row["radwinlocation"] . "\", \n";
       if ($row["radwinvlan"] !="") {
       echo "   RADWIN_Vlan = \"" . $row["radwinvlan"] . "\", \n";
      }
       echo "   RADWIN_RegisterAvailability = " . $row["radwinregisteravailability"] . "\n";

    }
} else {
    echo "0 results";
}
$conn->close();
?>
