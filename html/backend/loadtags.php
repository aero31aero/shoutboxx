<?php
//session_start();
require_once 'configuration.php';

try {   
    $conn = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);
    
} catch (Exception $pe) {
    die("Could not connect to the database $dbname :" . $pe->getMessage());
}

$userid=mysql_escape_string($_GET['userid']);

$sql = "SELECT * FROM tags WHERE userid='$userid';";

$result =$conn->query($sql);

$num_row=1;
$num_row = mysqli_num_rows($result);

if( $num_row >=1 ) { 
    //$_SESSION['user_name']=$username;
    
    while($tag_row = mysqli_fetch_array($result)) {
        echo "<li tagid='" . $tag_row['tagid'] . "'><span>&#10005;</span>" . $tag_row['tag'] . "</li>";
    }
    
}
else{
   echo "fail";
}      
   
		
$conn->close();
?>