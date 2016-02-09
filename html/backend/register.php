<?php
require_once 'configuration.php';
 
try {
   
    $conn = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);
    echo "Connected to $dbname at $dbhost successfully.";
} catch (Exception $pe) {
    die("Could not connect to the database $dbname :" . $pe->getMessage());
}

$username=mysql_escape_string($_GET['username']);
$password=mysql_escape_string($_GET['password']);
$bitsid=mysql_escape_string($_GET['bitsid']);


$sql = "INSERT INTO users (username,password,bitsid) 
    VALUES ( '$username' , '$password', '$bitsid' );";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
        
   
		
$conn->close();
?>