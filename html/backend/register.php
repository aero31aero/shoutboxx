<?php
require_once 'configuration.php';
 
try {
   
    $conn = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);
    //echo "Connected to $dbname at $dbhost successfully.";
} catch (Exception $pe) {
    die("Could not connect to the database $dbname :" . $pe->getMessage());
}

$username=mysql_escape_string($_GET['username']);
$password=mysql_escape_string($_GET['password']);
$bitsid=mysql_escape_string($_GET['bitsid']);

$sql = "SELECT * FROM users WHERE username='$username';";
$result =$conn->query($sql);
$num_row = mysqli_num_rows($result);
if( $num_row >=1 ) { 
    echo "fail";
}
else{
    $sql = "INSERT INTO users (username,password,bitsid) 
    VALUES ( '$username' , '$password', '$bitsid' );";
    //echo $sql . "<br>";
    if ($conn->query($sql) === TRUE) {
        $sql = "SELECT * FROM users WHERE username='$username';";
        $result =$conn->query($sql);
        $num_row=1;
        $user_row = mysqli_fetch_array($result);
        $num_row = mysqli_num_rows($result);
        if( $num_row >=1 ) { 
            //$_SESSION['user_name']=$username;
            echo $user_row['userid'];
        }
        else{
            echo "fail";
        } 
    } else {
        echo "fail";
    }
}  


        
   
		
$conn->close();
?>document.getElementById("post_wrapper").innerHTML=document.getElementById("post_wrapper").innerHTML + request.responseText;tagholderHtagHolderrefreshTags();
                    this.value="";