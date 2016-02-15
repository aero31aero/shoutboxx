<?php 
    require_once 'configuration.php';
 
    try {
        $conn = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);
    } catch (Exception $pe) {
        die("Could not connect to the database $dbname :" . $pe->getMessage());
    }

    $userid=mysql_escape_string($_GET['userid']);

	session_start(); 
	$_SESSION['userid'] == null; 
	session_destroy(); 
	echo 'Done';


    $sql = "INSERT INTO logs (userid,message) 
        VALUES ( '$userid' , 'LOGOUT' );";
        //echo $sql . "<br>";
    $conn->query($sql);
   
    $conn->close();
?>
