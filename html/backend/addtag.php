<?php
require_once 'configuration.php';
 
try {
   
    $conn = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);
    echo "Connected to $dbname at $dbhost successfully.";
} catch (Exception $pe) {
    die("Could not connect to the database $dbname :" . $pe->getMessage());
}

$tag=mysql_escape_string($_GET['tag']);
$userid=mysql_escape_string($_GET['userid']);
$sql = "INSERT INTO tags (userid,tag) VALUES ( $userid , '$tag' );";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
        
   
		
$conn->close();
?>