<?php
//session_start();
require_once 'configuration.php';

try {   
    $conn = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);
    
} catch (Exception $pe) {
    die("Could not connect to the database $dbname :" . $pe->getMessage());
}

$userid=mysql_escape_string($_GET['userid']);

$sql = "SELECT * FROM posts WHERE ismessage=1;";

$result =$conn->query($sql);

$num_row=0;
$num_row = mysqli_num_rows($result);

if( $num_row >=1 ) { 
    //$_SESSION['user_name']=$username;
    
    while($post_row = mysqli_fetch_array($result)) {
        echo "<li class='post'><div class='options'><span><i class='material-icons'>reply_all</i></span><span class='bookmarks'><i class='material-icons'>bookmark_border</i></span></div><div class='postcontent'><h3>" . $post_row['creator'] . "</h3><p>" . $post_row['message'] . "</p></div></li>";
    }
    
}
else{
   echo "fail";
}      
   
		
$conn->close();
?>