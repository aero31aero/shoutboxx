<?php
//session_start();
require_once 'configuration.php';

try {   
    $conn = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);
    
} catch (Exception $pe) {
    die("Could not connect to the database $dbname :" . $pe->getMessage());
}

$userid=mysql_escape_string($_GET['userid']);

$sql = "SELECT DISTINCT(maintag) FROM grouptags;";

$result =$conn->query($sql);

$num_row=1;
$num_row = mysqli_num_rows($result);

if( $num_row >=1 ) { 
    //$_SESSION['user_name']=$username;
    
    while($tag_row = mysqli_fetch_array($result)) {
        echo "<li onclick=addThisTag(this)>" . $tag_row['maintag'] . "</li>";
    }
    
}
else{
   //echo "fail";
}      
   
		
$conn->close();
?>