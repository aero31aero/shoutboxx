<?php
session_start();
require_once 'configuration.php';

try {   
    $conn = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);
    
} catch (Exception $pe) {
    die("Could not connect to the database $dbname :" . $pe->getMessage());
}

$username=mysql_escape_string($_GET['username']);
$password=mysql_escape_string($_GET['password']);

$sql = "SELECT * FROM users WHERE username='$username' AND password='$password';";

$result =$conn->query($sql);

$num_row=1;
$user_row = mysqli_fetch_array($result);
$num_row = mysqli_num_rows($result);

if( $num_row >=1 ) { 
    $_SESSION['userid']=$user_row['userid'];
    $_SESSION['username']=$user_row['username'];
    echo $user_row['userid'];
    $useridforlog=$user_row['userid'];
    $sql = "INSERT INTO logs (userid,message) 
    VALUES ( '$useridforlog' , 'LOGIN' );";
    //echo $sql . "<br>";
    $conn->query($sql);
}
else{
   echo "fail";
}      
   
		
$conn->close();
?>
