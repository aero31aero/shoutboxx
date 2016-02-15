<?php
require_once 'configuration.php';
 
try {
   
    $conn = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);
    //echo "Connected to $dbname at $dbhost successfully.";
} catch (Exception $pe) {
    die("Could not connect to the database $dbname :" . $pe->getMessage());
}

$userid=mysql_escape_string($_GET['userid']);
$feedback=mysql_escape_string($_GET['feedback']);

$sql = "INSERT INTO feedbacks (userid,feedback) 
VALUES ( '$userid' , '$feedback');";
//echo $sql . "<br>";
if ($conn->query($sql) === TRUE) {
    echo "success";
} else {
    echo "fail";
}
 


        
   
		
$conn->close();
?>
