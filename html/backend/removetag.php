<?php
require_once 'configuration.php';
 
try {
   
    $conn = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);
} catch (Exception $pe) {
    die("Could not connect to the database $dbname :" . $pe->getMessage());
}

$tagid=mysql_escape_string($_GET['tagid']);
$userid=mysql_escape_string($_GET['userid']);


$sql = "UPDATE tags SET isactive = 'FALSE' WHERE tagid = '$tagid';";

if ($conn->query($sql) === TRUE) {
	$tagidforlog = $tagid;
        $useridforlog = $userid;
        $sql = "INSERT INTO logs (userid,message,tagid) 
        VALUES ( '$useridforlog' , 'TAG_REMOVE', '$tagidforlog' );";
        //echo $sql . "<br>";
        $conn->query($sql);
    echo"success";
} else {
    echo "fail";
}
        
   
$conn->close();
?>
