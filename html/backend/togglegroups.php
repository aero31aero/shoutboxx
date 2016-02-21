<?php
//session_start();
require_once 'configuration.php';

try {   
    $conn = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);
    
} catch (Exception $pe) {
    die("Could not connect to the database $dbname :" . $pe->getMessage());
}

$userid=mysql_escape_string($_GET['userid']);
$groupid=mysql_escape_string($_GET['groupid']);
$isactive=mysql_escape_string($_GET['isactive']);

$sql = "SELECT * FROM usergroups WHERE isactive='1' AND userid='$userid' AND groupid='$groupid';";
$result =$conn->query($sql);

$num_row = mysqli_num_rows($result);
if( $num_row >=1 ) { 
    //$_SESSION['user_name']=$username;
    $sql = "UPDATE usergroups SET isactive=" . $isactive . " WHERE userid=" . $userid . " AND groupid=" . $groupid . ";";
    echo $sql;
}
else{
    $sql = "INSERT INTO usergroups (userid,groupid,isactive) VALUES ('$userid','$groupid','$isactive');";
    echo $sql;
}      
try {   
    $result = $conn->query($sql);
    echo 'done';
} catch (Exception $pe) {
    echo 'fail';
}
		
$conn->close();
?>