<?php
require_once 'configuration.php';
 
try {
   
    $conn = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);
} catch (Exception $pe) {
    die("Could not connect to the database $dbname :" . $pe->getMessage());
}

$tagid=mysql_escape_string($_GET['tagid']);

$sql = "DELETE FROM tags WHERE tagid = '$tagid';";

if ($conn->query($sql) === TRUE) {
    echo"success"; 
} else {
    echo "fail";
}
        
   
$conn->close();
?>