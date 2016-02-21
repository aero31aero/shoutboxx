<?php
//session_start();
require_once 'configuration.php';

try {   
    $conn = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);
    
} catch (Exception $pe) {
    die("Could not connect to the database $dbname :" . $pe->getMessage());
}

$userid=mysql_escape_string($_GET['userid']);

$sql = "SELECT groupname,groupid FROM groups WHERE isactive=1;";
$result =$conn->query($sql);

$num_row=1;
$num_row = mysqli_num_rows($result);

if( $num_row >=1 ) { 
    //$_SESSION['user_name']=$username;
    
    while($tag_row = mysqli_fetch_array($result)) {
        $sql2="SELECT * FROM usergroups WHERE userid=" . $userid . " AND groupid=" . $tag_row['groupid'] . " AND isactive=1;";
        $result2 =$conn->query($sql2);
        $num_row2=0;
        $num_row2 = mysqli_num_rows($result2);
        
        echo "<li class='listtoggle";        
        if($num_row2 >=1){
            echo " active ";
        }
        echo "' ";
        echo " groupid=" . $tag_row['groupid'];    
        echo " ><div class='checkbox material-icons'>";
        if($num_row2 >=1){
            echo "check";
        }
        echo "</div><span class='label'>" . $tag_row['groupname'] . "</span></li>";
    }
    
}
else{
   //echo "fail";
}      
   
		
$conn->close();
?>